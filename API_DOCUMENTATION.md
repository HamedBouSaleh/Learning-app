# Learning Platform REST API Documentation

## Overview
This REST API provides CRUD operations for the Learning Management System database.

**Base URL:** `http://localhost:8000/api`

**Response Format:** JSON

---

## API Endpoints

### 1. COURSES API

#### Get All Courses
```http
GET /api/courses
```
**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Introduction to Programming",
      "difficulty": "Beginner",
      "is_published": true,
      ...
    }
  ]
}
```

#### Create Course
```http
POST /api/courses
```
**Request Body:**
```json
{
  "title": "Web Development Basics",
  "short_description": "Learn HTML, CSS, JavaScript",
  "difficulty": "Beginner",
  "created_by": 1,
  "is_published": true
}
```

#### Get Single Course
```http
GET /api/courses/{id}
```

#### Update Course
```http
PUT /api/courses/{id}
```
**Request Body:** (Same as POST, all fields optional)

#### Delete Course
```http
DELETE /api/courses/{id}
```

---

### 2. LESSONS API

#### Get All Lessons
```http
GET /api/lessons
```

#### Create Lesson
```http
POST /api/lessons
```
**Request Body:**
```json
{
  "course_id": 1,
  "title": "Introduction to Variables",
  "content": "Variables are containers...",
  "lesson_type": "Video",
  "order_position": 1,
  "video_url": "https://example.com/video.mp4"
}
```

#### Get Single Lesson
```http
GET /api/lessons/{id}
```

#### Update Lesson
```http
PUT /api/lessons/{id}
```

#### Delete Lesson
```http
DELETE /api/lessons/{id}
```

---

### 3. QUIZZES API

#### Get All Quizzes
```http
GET /api/quizzes
```

#### Create Quiz
```http
POST /api/quizzes
```
**Request Body:**
```json
{
  "course_id": 1,
  "lesson_id": 2,
  "title": "Variables Quiz",
  "passing_score": 70,
  "time_limit": 30,
  "allow_retake": true,
  "max_attempts": 3
}
```

#### Get Single Quiz
```http
GET /api/quizzes/{id}
```

#### Update Quiz
```http
PUT /api/quizzes/{id}
```

#### Delete Quiz
```http
DELETE /api/quizzes/{id}
```

---

### 4. ENROLLMENTS API

#### Get All Enrollments
```http
GET /api/enrollments
```

#### Enroll Student
```http
POST /api/enrollments
```
**Request Body:**
```json
{
  "user_id": 5,
  "course_id": 1,
  "status": "Active"
}
```

#### Get Single Enrollment
```http
GET /api/enrollments/{id}
```

#### Update Enrollment
```http
PUT /api/enrollments/{id}
```
**Request Body:**
```json
{
  "status": "Completed"
}
```

#### Delete Enrollment
```http
DELETE /api/enrollments/{id}
```

---

### 5. CERTIFICATES API

#### Get All Certificates
```http
GET /api/certificates
```

#### Issue Certificate
```http
POST /api/certificates
```
**Request Body:**
```json
{
  "user_id": 5,
  "course_id": 1,
  "instructor_name": "John Doe"
}
```
**Note:** `verification_code` is auto-generated

#### Get Single Certificate
```http
GET /api/certificates/{id}
```

#### Verify Certificate
```http
GET /api/certificates/verify/{verification_code}
```

#### Delete Certificate
```http
DELETE /api/certificates/{id}
```

---

## HTTP Status Codes

| Code | Description |
|------|-------------|
| 200  | OK - Request successful |
| 201  | Created - Resource created successfully |
| 404  | Not Found - Resource doesn't exist |
| 409  | Conflict - Resource already exists |
| 422  | Validation Error - Invalid data |

---

## Testing the API

### Using Postman
1. Import the collection
2. Set base URL: `http://localhost:8000/api`
3. Test each endpoint

### Using cURL (Command Line)

**Get All Courses:**
```bash
curl http://localhost:8000/api/courses
```

**Create Course:**
```bash
curl -X POST http://localhost:8000/api/courses \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Course",
    "difficulty": "Beginner",
    "created_by": 1
  }'
```

**Update Course:**
```bash
curl -X PUT http://localhost:8000/api/courses/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Updated Course Title"
  }'
```

**Delete Course:**
```bash
curl -X DELETE http://localhost:8000/api/courses/1
```

---

## OOP Principles Used

### 1. **Encapsulation**
- Models encapsulate database logic
- Controllers encapsulate business logic
- Validation rules encapsulated in request validation

### 2. **Abstraction**
- Base Controller provides common functionality
- Eloquent ORM abstracts SQL queries

### 3. **Inheritance**
- All controllers extend `Controller` base class
- All models extend `Model` base class

### 4. **Relationships**
- Models define relationships (belongsTo, hasMany)
- Database foreign keys enforce referential integrity

---

## Next Steps

1. Start Laravel server:
   ```bash
   php artisan serve
   ```

2. Test endpoints with Postman or cURL

3. Add authentication middleware for protected routes

4. Create controllers for remaining entities (Questions, Answers, etc.)
