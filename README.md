Full e-commerce website made with *Symfony*
- twig
- routing
- forms validation
- easyAdmin
- PHP mailjet
- Stripe
- Security
- Doctrine

# clone project
`git clone https://github.com/brazillierjo/laboutiquefr.git`

# install project
`cd laboutique fr`
`composer install`
`npm install`
`npm run watch`

# migrate db
`symfony console make:migration` (with symfony CLI installed)
`symfony console doctrine:migrations:migrate`

# if error manifest.json (assets/controllers.js missing)
`composer recipes -o`