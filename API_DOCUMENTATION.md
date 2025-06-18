# API Documentation

## Endpoints

### Get a user by ID
- **URL**: `/users/{id}`
- **Method**: `GET`
- **Parameters**:
  - `id` (integer, required): The ID of the user
- **Responses**:
  - `200 OK`: User found. Returns user details
  - `404 Not Found`: User not found

### Get a task by ID
- **URL**: `/tasks/{id}`
- **Method**: `GET`
- **Parameters**:
  - `id` (integer, required): The ID of the task
- **Responses**:
  - `200 OK`: Task found. Returns task details
  - `404 Not Found`: Task not found

### Get tasks for a user
- **URL**: `/users/{userId}/tasks`
- **Method**: `GET`
- **Parameters**:
  - `userId` (integer, required): The ID of the user
- **Responses**:
  - `200 OK`: List of the user's tasks
  - `404 Not Found`: User not found

### Create a task for a user
- **URL**: `/users/{userId}/tasks`
- **Method**: `POST`
- **Parameters**:
  - `userId` (integer, required): The ID of the user
- **Request body**:
  - `title` (string, required): The title of the task
  - `description` (string, optional): The description of the task
- **Responses**:
  - `201 Created`: Task  created with success
  - `400 Bad Request`: Invalid data
  - `404 Not Found`: User not found

### Delete a task
- **URL**: `/tasks/{id}`
- **Method**: `DELETE`
- **Parameters**:
  - `id` (integer, required): The ID of the task
- **Responses**:
  - `204 No Content`: Task successfully deleted
  - `404 Not Found`: Task not found