import datetime
import os
import platform
import json
import random
import time
import urllib
import requests
from urllib.request import urlopen
from pprint import pprint
from pymongo import MongoClient
import signal

def Exit_gracefully(signal, frame):
    x=input("You really wanna quit ?? [y/n] : ")
    if x=="y":
        jdump()
        exit(0)


v = 230
i = 0
f = 50
k = 0
pwrarray = []
dmpcnt = 30  
mtrreading = 0
healthchecker = ""
data = {}
data['Meter'] = [] 

area =  input("Enter Your Area Code   :  01:Eastern\t02:Western\t03:Northern \t04:Southern   ")
usage = input("Enter Consumption Type :  01:Rural  \t02:Urben  \t03:Industrial ...........       ")
meterid_ = str(12)+area+usage+str(random.randint(1110,6666))
meterid = int(meterid_)
def getElec(e):
    global v
    global i
    v = random.randint(180, 270)
    i = round(random.uniform(0.2, 0.6), 1)
    if e == 1:
        return i
    elif e == 2:
        return v
    else:
        return "Meter Fault"


def calcPower():
    global healthchecker
    v, i = getElec(2), getElec(1)
    if v == "Meter Fault":
        healthchecker = v
    else:
        p = v * i
    return round(p, 1)


def getMtrReading():
    global pwrarray
    global mtrreading
    pwravg = sum(pwrarray) / len(pwrarray)
    newmtrreading = (pwravg / 1000) + mtrreading
    mtrreading = newmtrreading
    return newmtrreading


def getHealth():
    pass


def mongoUpdate():
    client = MongoClient()
    global healthchecker
    global k
    db = client.test
    collection = db.testmeter

    post = {
        "MeterNo":meterid,
        "Timestamp":meterdt,
        "Reading":mtrreading,
        "Status":"on"
    }
    k = collection.insert_one(post)
    if k == 0:
        healthchecker="Database Connection Error"
    else:
        healthchecker="Connected"
        k=0
        


def disOnMeter():
    global mtrreading
    os.system('cls')
    print("=====================================================")
    print("=====================================================")
    print("\t ========= Bharat Electricity Board =========       ")
    print("====================================================")
    print("\t Meter ID: ", meterid)
    print("\t Date: ", meterdt, "\t KW: ", power / 1000)
    print("\t Reading: ", mtrreading)
    print("\t Health: ", healthchecker)
    print("=====================================================")
    print("=====================================================")
    
'''Akio jdump'''
def jdump():
    with open('dumpdata.json', 'w') as outfile:  
        json.dump(data, outfile)

def arrupdt():
    data['Meter'].append({  
    'Meter_Id': meterid,
    'Date': meterdt,
    'Reading':  mtrreading,
    'Health' :healthchecker
    })

loopcnt = 0
while True:
    power = calcPower()
    pwrarray += [power]
    meterfw = platform.system()[2]
    meterdt = datetime.datetime.now().strftime("%D-%m-%Y-%H:%M")
    loopcnt = loopcnt + 1
    if loopcnt == dmpcnt:
        loopcnt = 0
        dmpme = 'yes'
        mtrreading = getMtrReading()
        pwrarray = []
    else:
        dmpme = 'no'

    postvalues = {
        'mid': meterid,
        'dt': meterdt,
        'p': power,
        'v': v,
        'i': i,
        'fw': meterfw,
        'mr': mtrreading,
        'dmp': dmpme
    }
    postdata = urllib.parse.urlencode(postvalues)
    
    disOnMeter()
    mongoUpdate()
    arrupdt()
    if k == 0:
        healthchecker="Database Connection Error"
    else:
        healthchecker="Connected"
        k=0
    time.sleep(2)
    signal.signal(signal.SIGINT, Exit_gracefully)