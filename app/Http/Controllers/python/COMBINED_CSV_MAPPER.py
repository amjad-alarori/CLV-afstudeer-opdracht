import pandas as pd
from datetime import datetime
import csv
import psycopg2 as pg
import pandas.io.sql as psql
import sys

 
# SQL Data
# connection = pg.connect("host= db-postgresql-ams3-07962-do-user-11061998-0.b.db.ondigitalocean.com port=25060 dbname=rfm user=doadmin password=pKBKfj6yN2LSJ24g")
# sql = "SELECT * FROM rfm_table"
# data_rfm = psql.read_sql(sql, connection)
# data_rfm['InvoiceDate'] = pd.to_datetime(data_rfm['InvoiceDate'])

if "lightspeed" in sys.argv[1]:
    # Read Lightspeed Data
  data_rfm = pd.read_csv('../storage/app/public/uploads/'+sys.argv[1], sep=';')
elif "magento" in sys.argv[1]:
    # Read Magento Data
    reader = pd.read_csv('../storage/app/public/uploads/'+sys.argv[1], sep = None, iterator = True, engine='python')
    inferred_sep = reader._engine.data.dialect.delimiter
    data_rfm = pd.read_csv('../storage/app/public/uploads/'+sys.argv[1], sep=inferred_sep)
else: 
    "this is not a valid file"

    


if 'Purchase Date' in data_rfm:
    print('magento')

        ###### Changes for Lightspeed ######
# Change to InvoiceDate
    data_rfm.rename(columns={'Purchase Date':'InvoiceDate'}, inplace=True)

    # Change to CustomerID
    data_rfm['CustomerID'] = data_rfm['Customer Email'].factorize()[0] + 1

    # Change to TotalPrice
    data_rfm.rename(columns={"Grand Total (Purchased)": "TotalPrice"}, inplace=True)

    # Change to Invoice
    data_rfm.rename(columns={"ID": "Invoice"}, inplace = True)

    # Data change 1 -->
    data_rfm['InvoiceDate'] = pd.to_datetime(data_rfm['InvoiceDate']) #, format='%d-%m-%Y @ %M:%S'


    # # Data change 5 --> not needed for magento
    # data_rfm["TotalPrice"] = data_rfm["TotalPrice"].str.replace(',', '.').astype(float)



    # Datetime object current date & time
    today_date = datetime.now()
    today_date


    recency_df = (today_date - data_rfm.groupby("CustomerID").agg({"InvoiceDate":"max"}))
    recency_df['Recency'] = recency_df["InvoiceDate"].apply(lambda x: x.days)
    recency_df.drop(columns=['InvoiceDate'], inplace=True)


    freq_df = data_rfm.groupby(["CustomerID","Invoice"]).agg({"Invoice":"count"})
    freq_df = freq_df.groupby("CustomerID").agg({"Invoice":"sum"})
    freq_df.rename(columns={"Invoice": "Frequency"}, inplace = True)




    monetary_df = data_rfm.groupby("CustomerID").agg({"TotalPrice":"sum"})
    monetary_df.rename(columns={"TotalPrice": "Monetary"}, inplace = True)

else:
    print('Lightspeed')


            ###### Changes for Lightspeed ######
    # Data change 1 -->
    data_rfm['InvoiceDate'] = pd.to_datetime(data_rfm['Added'], format='%d-%m-%Y @ %M:%S')

    # Data change 2 --> alternative: data_rfm['CustomerID'] = data_rfm['Customer']
    data_rfm.rename(columns={"Customer": "CustomerID"}, inplace = True)

    # Data change 3 --> alternative: data_rfm['Invoice'] = data_rfm['Order_ID']
    data_rfm.rename(columns={"Order_ID": "Invoice"}, inplace = True)

    # Data change 4 -->
    data_rfm.rename(columns={"Price_total": "TotalPrice"}, inplace=True)

    # Data change 5 -->
    data_rfm["TotalPrice"] = data_rfm["TotalPrice"].str.replace(',', '.').astype(float)



    # Datetime object current date & time
    today_date = datetime(2022,7,11)
    today_date


    recency_df = (today_date - data_rfm.groupby("CustomerID").agg({"InvoiceDate":"max"}))
    recency_df['Recency'] = recency_df["InvoiceDate"].apply(lambda x: x.days)
    recency_df.drop(columns=['InvoiceDate'], inplace=True)


    freq_df = data_rfm.groupby(["CustomerID","Invoice"]).agg({"Invoice":"count"})
    freq_df = freq_df.groupby("CustomerID").agg({"Invoice":"sum"})
    freq_df.rename(columns={"Invoice": "Frequency"}, inplace = True)




    monetary_df = data_rfm.groupby("CustomerID").agg({"TotalPrice":"sum"})
    monetary_df.rename(columns={"TotalPrice": "Monetary"}, inplace = True)


rfm = pd.concat([recency_df, freq_df, monetary_df],  axis=1)



rfm["RecencyScore"] = pd.qcut(rfm['Recency'], 5, labels = [5, 4, 3, 2, 1])
rfm["FrequencyScore"] = pd.qcut(rfm['Frequency'].rank(method = "first"), 5, labels = [1, 2, 3, 4, 5])
rfm["MonetaryScore"] = pd.qcut(rfm['Monetary'], 5, labels = [1, 2, 3, 4, 5])



rfm["RFM_SCORE"] = rfm['RecencyScore'].astype(str) + rfm['FrequencyScore'].astype(str) + rfm['MonetaryScore'].astype(str)



seg_map = {
    r'[1-2][1-2]': 'Hibernating',
    r'[1-2][3-4]': 'At Risk',
    r'[1-2]5': 'Can\'t Loose',
    r'3[1-2]': 'About to Sleep',
    r'33': 'Need Attention',
    r'[3-4][4-5]': 'Loyal Customers',
    r'41': 'Promising',
    r'51': 'New Customers',
    r'[4-5][2-3]': 'Potential Loyalists',
    r'5[4-5]': 'Champions'
}


rfm['Segment'] = rfm['RecencyScore'].astype(str) + rfm['FrequencyScore'].astype(str)
rfm['Segment'] = rfm['Segment'].replace(seg_map, regex=True)

rfm['RecencyScore'] = rfm.RecencyScore.astype('object')
rfm['FrequencyScore'] = rfm.FrequencyScore.astype('object')
rfm['MonetaryScore'] = rfm.MonetaryScore.astype('object')
modified = rfm.reset_index()
modified.rename(columns={"CustomerID": "customer_id", "Recency": "recency", "Frequency": "frequency", "Monetary": "monetary", "RecencyScore": "recency_score", "FrequencyScore": "frequency_score", "MonetaryScore": "monetary_score", "RFM_SCORE": "rfm_score", "Segment": "segment"}, inplace = True)

from sqlalchemy import create_engine
engine = create_engine('postgresql+psycopg2://doadmin:pKBKfj6yN2LSJ24g@db-postgresql-ams3-07962-do-user-11061998-0.b.db.ondigitalocean.com:25060/clv_laravel')
modified.to_sql('rfms', engine, if_exists='replace',index=False)


print('Sucess')

