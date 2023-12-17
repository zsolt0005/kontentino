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
 * [ ] Endpoint GET /stats to retrieve the 3 aggregated data
   * 10 biggest planets
   * Terrain distributions (How many % of planets have a specific terrain, ordered by % DESC)
   * Species distributions (How many % of species are living on a planet, ordered by count DESC)

## 4. 
 * [x] Create a migration for the logbook
   * id, person_id, planet_id, location, severity, note, created_at
 * [x] Create the Model and service for the table
 * [x] Create a new endpoint POST /logbook/create
   * Take and validate data
   * Save in the DB
     * note should be encrypted
 * [x] Create a new endpoint GET /logbook/{id}
   * Return log book data
 * [x] Test both endpoints

