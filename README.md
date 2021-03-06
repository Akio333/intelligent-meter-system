# Intelligent Meter System

### Developed by
Suyog Mule\
Sumukh Maduskar\
Pankaj Masaye

## Description
  The intelligent electricity meter is a smart reading body which monitors, calculates
and stores the energy values and customer details. First, it monitors the energy values
consumed by the customer/utilizer to analyze the gross usage on daily as well as monthly
basis. Then, it calculates the total amount of energy used and stores the data in a database
with allotting a unique ID to each meter body.\
  In this scenario, the system will include python programming techniques that generate
a dummy electricity meter. It will produce random values which provide meter ID, current
date of reading, values of electricity units consumed. It will also indicate the status of meter
whether it is working properly or not. Each meter will be booted on console windows by
running the meter program in python. It will create a new consumer meter that will generate
new data with a different unique ID.\
  This data will be in a MongoDB database which is originally a document-oriented
NoSQL database. It will act as storage for all the data generated by active meters on the
system. Data generated will be maneuvered in JSON file which will be stored on MongoDB
as a document. A front-end webpage will be generated to fetch this data at consumer/user end
to figure out the details of each electricity meter. The webpage will be generated in HTML
and CSS to enhance the front-end UI.\
  This scenario can be implemented on the hardware platform as well, by using IoT
based compute modules with physical electricity reading meter. Sensors and relays are used
to manage the electricity supply at domestic level appliances by taking readings of the
specified time unit. Data from sensors and reading meter can be transferred to the database to
generate a dataset of electricity reading for further analysis. It will help to analyze electricity
consumption and can help or suggest the actions to be taken from energy saving perspectives.
