# TODO

## 1. Create an artisan command, that will sync the list of all known planets and their residents
 * [x] Create migrations
   *Create the necessary tables
 * [x] Create models
   * With setters and getters
 * [x] Create services for models
   * For easy testing
 * [x] Fetch data from API
 * [x] Save fetched data to the database
 * [x] Cleanup
 * [x] Larastan lvl 9
 * [x] Tests for the command
 * [x] Git pipeline

## 2. Create a simple paginated listing of the planets
 * [x] Create a view for the HomeController with bootstrap
 * [x] A simple table template
   * Load data for the current page
 * [x] Pagination: show at most 5 pages eg 1 .. 4 5 6 .. 10
 * [x] Filters
   * Diameter
   * Rotation period
   * Gravity

## 3. 

## 4. 
 * [ ] Create a migration for the logbook
   * id, person_id, planet_id, location, servity, note, created_at
 * [ ] Create the Model and service for the table
 * [ ] Create a new endpoint POST /logbook/create
   * Take and validate data
   * Save in the DB
     * note should be encrypted
 * [ ] Create a new endpoint GET /logbook/{id}
   * Return log book data
 * [ ] OpenApi Documentation for both endpoints

