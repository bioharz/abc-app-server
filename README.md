# ABC-App Server

## Setup

 - Copy `.env.example` to `.env` and change config accordingly
 - Run `composer install`
 
## API

| Method | URI | Payload | Description |
| ----- | ----- | ----- | ----- |
| POST | /tests | {<br/>"code" : "test code",<br/>"person" : "person name"<br/>} | Start a test execution for a specific test identified by a `code` |
| GET | /tests/:code |  | Retrieve all questions and answers for a specific test execution identified by a `:code` |
| PUT | /tests/:code | {<br/>"3" : [3, 4],<br/>"5" : [6, 9]<br/>} | Save questions and answers identified by their id |
