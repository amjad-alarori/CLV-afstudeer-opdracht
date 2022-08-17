import pandas as pd
import numpy as np
import psycopg2 as pg
import pandas.io.sql as psql
import datetime as dt
import sys


# data = pd.read_csv('app\Http\Controllers\python\data_lightspeed.csv', sep=';')


data = pd.read_csv('../storage/app/public/uploads/'+sys.argv[1], sep=';')




df = data.copy()



## 1. What is the number of unique products?

df["Product_title"].nunique()



## 2. Which product do you have?

df["Product_title"].value_counts()



## 3. Which product is the most ordered?

df.groupby("Product_title").agg({"Quantity":"sum"})




## 4. How do we rank this output?

df.groupby("Product_title").agg({"Quantity":"sum"}).sort_values("Quantity", ascending = False)



## 5. How many invoices have been issued?

df["Order_ID"].nunique()




## 6. How much money has been earned per invoice?

df['Price_total'] = df['Price_total'].str.replace(',','').astype(np.float64) /100

df["TotalPrice"] = df["Quantity"]*df["Price_total"]

df.groupby("Order_ID").agg({"TotalPrice":"sum"})




## 7. Which are the most expensive products?

df.sort_values("Price_total", ascending = False)




## 8. How many orders came from which country?

df["Country"].value_counts()





## 9. Which country gained how much?

df.groupby("Country").agg({"Price_total":"sum"}).sort_values("Price_total", ascending = False)





## 10. Which product is the most returned?

df[df['Status'].str.startswith("C", na=False)].sort_values("Quantity", ascending = True)

df.shape

df.describe([0.01,0.05,0.10,0.25,0.50,0.75,0.90,0.95, 0.99]).T

for feature in ["Quantity","Price_total","TotalPrice"]:

    Q1 = df[feature].quantile(0.01)
    Q3 = df[feature].quantile(0.99)
    IQR = Q3-Q1
    upper = Q3 + 1.5*IQR
    lower = Q1 - 1.5*IQR

    if df[(df[feature] > upper) | (df[feature] < lower)].any(axis=None):
        print(feature,"yes")
        print(df[(df[feature] > upper) | (df[feature] < lower)].shape[0])
    else:
        print(feature, "no")


df['Added'] =  pd.to_datetime(df['Added'], format='%d-%m-%Y @ %H:%M')

df["Added"].min()

df["Added"].max()

today_date = dt.datetime.now()
# today_date = dt.datetime(2022,5,21)
today_date





## 11. Show the last shopping dates of each customer.

df.groupby("Customer").agg({"Added":"max"})
(today_date - df.groupby("Customer").agg({"Added":"max"}))

temp_df = (today_date - df.groupby("Customer").agg({"Added":"max"}))
temp_df.rename(columns={"Added": "Recency"}, inplace = True)

recency_df = temp_df["Recency"].apply(lambda x: x.days)

df.groupby("Customer").agg({"Added": lambda x: (today_date - x.max()).days})

temp_df = df.groupby(["Customer","Order_ID"]).agg({"Order_ID":"count"})

temp_df.groupby("Customer").agg({"Order_ID":"count"})

freq_df = temp_df.groupby("Customer").agg({"Order_ID":"sum"})
freq_df.rename(columns={"Order_ID": "Frequency"}, inplace = True)

monetary_df = df.groupby("Customer").agg({"TotalPrice":"sum"})





# Changinh Names

monetary_df.rename(columns={"TotalPrice": "Monetary"}, inplace = True)

print(recency_df.shape,freq_df.shape,monetary_df.shape)

rfm = pd.concat([recency_df, freq_df, monetary_df],  axis=1)





## Now, we need to score according to the most recent (Recency), the cyclic (Frequency) and the monetary expenditure (Monetary).

## 13. Scoring for RFM

# - Let's start with the last 5 here. Let's use the 'qcut' method to score.


rfm["RecencyScore"] = pd.qcut(rfm['Recency'], 5, labels = [5, 4, 3, 2, 1])   
rfm["FrequencyScore"] = pd.qcut(rfm['Frequency'].rank(method = "first"), 5, labels = [1, 2, 3, 4, 5])
rfm["MonetaryScore"] = pd.qcut(rfm['Monetary'], 5, labels = [1, 2, 3, 4, 5])


(rfm['RecencyScore'].astype(str) + 
 rfm['FrequencyScore'].astype(str) + 
 rfm['MonetaryScore'].astype(str))

rfm["RFM_SCORE"] = rfm['RecencyScore'].astype(str) + rfm['FrequencyScore'].astype(str) + rfm['MonetaryScore'].astype(str)
rfm

rfm.describe().T

rfm[rfm["RFM_SCORE"] == "555"]

rfm[rfm["RFM_SCORE"] == "111"]

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
modified.rename(columns={"Customer": "customer_id", "Recency": "recency", "Frequency": "frequency", "Monetary": "monetary", "RecencyScore": "recency_score", "FrequencyScore": "frequency_score", "MonetaryScore": "monetary_score", "RFM_SCORE": "rfm_score", "Segment": "segment"}, inplace = True)


from sqlalchemy import create_engine
engine = create_engine('postgresql+psycopg2://doadmin:pKBKfj6yN2LSJ24g@db-postgresql-ams3-07962-do-user-11061998-0.b.db.ondigitalocean.com:25060/clv_laravel')
modified.to_sql('rfms', engine, if_exists='replace',index=False)

