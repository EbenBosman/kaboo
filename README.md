
  

# Getting started with KABOO

  

## Pre-requisites  

[Download & Install Docker](https://docs.docker.com/get-docker/) for your local environment.  

Ensure you have a SendGrid account set up and ready to use.

## Setup

Ensure that the correct values are in place in the `.env` file:

 1. SENDGRID_KEY - Set up a WebAPI at [SendGrid](https://sendgrid.com/).
 2. KABOO_CONTACT_EMAIL - Which email address you would like the contact emails to go to.
 3. WEB_ADDRESS - At the time of writing this, a domain wasn't purchased yet and this will be used in the email templates.
  
## Run the application

`docker-compose build`

`docker-compose up`

Then go to [http://127.0.01](http://127.0.01) on your local browser.

## Useful links for troubleshooting

Docker project initially inspired by this article: https://www.sitepoint.com/docker-php-development-environment/

To peer inside a Docker container: https://stackoverflow.com/questions/20813486/exploring-docker-containers-file-system
Look for the answer with title `UPDATE: EXPLORING`