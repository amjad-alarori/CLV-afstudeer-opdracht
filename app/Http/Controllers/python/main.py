
from flask import Flask
import pandas as pd
from flask_restful import Resource, Api, reqparse

app = Flask(__name__)
api = Api(app)

class Rfms(Resource):
    # methods go here
    def get(self):
        data = pd.read_csv('public\data.csv', sep=';')  # read CSV
        data = data.to_dict()  # convert dataframe to dictionary
        return {'data': data}, 200  # return data and 200 OK code
    pass

api.add_resource(Rfms, '/')  # '/users' is our entry point


if __name__ == '__main__':
    app.run()  # run our Flask app