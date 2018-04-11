# ABC-App Server

## Setup

 - Copy `.env.example` to `.env` and change config accordingly
 - Run `composer install`
 
## API

| Method | URI | Payload | Description |
| ----- | ----- | ----- | ----- |
| POST | /tests | ```{ "code" : "test code", "person" : "person name" }``` | Start a test execution for a specific test identified by a `code` |
| GET | /tests/:code |  | Retrieve all questions and answers for a specific test execution identified by a `:code` |
| PUT | /tests/:code | ```{ "3" : [3, 4], "5" : [6, 9] }``` | Save questions and answers identified by their id |
