# Event Management API

## Project Description

The **Event Management API** is a robust RESTful API designed to manage events, categories, and ticketing systems. It provides endpoints for user authentication, event creation, management of categories, and ticket purchasing, making it ideal for applications focused on event organization and management.

## Features

- **User Authentication**: Register, log in, and log out users.
- **Category Management**: Create, read, update, and delete event categories.
- **Event Management**: Create, list, update, and delete events.
- **Ticketing System**: Purchase, share, and manage tickets for events.
- **Secure API**: Token-based authentication for secure access to endpoints.

## Setting Up the Laravel API Environment

Follow these steps to set up and run the Event Management API locally:

### Prerequisites

- PHP >= 8.0
- Composer
- Laravel >= 10
- MySQL

### Installation Steps

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/younes-alkashmi/event-management.git
   cd event-management
   ```

2. **Install Dependencies**:
   Run the following command to install all required PHP packages:
   ```bash
   composer install
   ```

3. **Set Up Environment Variables**:
   - Copy the `.env.example` file to create your `.env` file:
     ```bash
     cp .env.example .env
     ```
   - Open the `.env` file and update the database connection details:
     ```plaintext
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**:
   To set up the database schema, run:
   ```bash
   php artisan migrate
   ```

6. **Run Seeders (Optional)**:
   We have seeders to populate your database with initial data, run:
   ```bash
   php artisan db:seed
   ```

7. **Run Queue Workers (If Applicable)**:
   We have queues for handling some tasks, the queue worker should be running:
   ```bash
   php artisan queue:work
   ```

8. **Run the API Server**:
   Start the local development server:
   ```bash
   php artisan serve
   ```
   Your API will be accessible at `http://localhost:8000`.

## Importing the Postman Collection

Follow these steps to import the Postman collection for testing the API:

1. **Open Postman**: Launch the Postman application on your computer.

2. **Import Collection**:
   - Click on the **Import** button located in the top left corner.
   - In the Import dialog, choose the **Raw text** or **File** option, depending on whether you have the JSON saved as a file or as text.
   - Paste or upload the JSON collection provided in this project.

3. **Set Environment Variables**:
   - Create a new environment in Postman and add a variable named `token`. This variable will be used to store the authentication token after logging in.
   - You can add token in globals in postman enviroment so it can be sent automatically with every request.

4. **Testing the API**:
   - Start by registering a new user using the **Register User** endpoint.
   - Log in with the registered user credentials to obtain a token.
   - Use the token for subsequent requests by including it in the **Authorization** header (e.g., `Bearer {{token}}`).

5. **Explore Endpoints**: 
   - Utilize the collection to interact with different API endpoints, testing functionalities like creating categories, events, and purchasing tickets.

## Login Credentials for Testing

To test as an admin or manager, you can use the following predefined accounts:

- **Admin Account**:
  - **Email**: admin@example.com
  - **Password**: admin123

- **Manager Account**:
  - **Email**: manager@example.com
  - **Password**: manager123

## Testing the Endpoints

Here are the key endpoints you can test:

- **Register User**: Register a new user.
- **Login User**: Log in to get a token(can be used after registering).
- **Login Admin**: Log in to get an admin token (can be used after seeding db).
- **Login Manager**: Log in to get a manager token(can be used after seeding db).
- **Logout User**: Use the token to log out.
- **Create Category**: Only accessible to (admin/manager) users.
- **Get All Categories**: Retrieve all categories.
- **Create Event**: Create an event (admin/manager only).
- **Get All Events**: Retrieve all events (admin/manager/basic users).
- **Get All Tickets for specific Event**: Retrieve all tickets for an event (admin/manager only).
- **Purchase Tickets**: Purchase tickets for a specific event (basic users).
- **Share Tickets**: Share tickets with other users (basic users).

## Conclusion

Use this API to build sophisticated event management applications with seamless user interaction and robust backend support.
