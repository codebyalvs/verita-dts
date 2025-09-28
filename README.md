# Project Blueprint

## 1. Overview

This project is a full-stack web application built with the Laravel framework. It provides a starting point for a modern, performant, and secure web application, leveraging Laravel's powerful features for routing, data handling, and backend logic.

## 2. Implemented Features & Design

### 2.1. Authentication

*   **Login and Registration:** A complete authentication system is in place, allowing users to create accounts and log in.
*   **Password Reset with Verification Code:** The password reset functionality has been updated to use a verification code sent to the user's email, instead of a password reset link. This includes:
    *   **Sending a 6-digit verification code** to the user's email address.
    *   **A form to enter the verification code.**
    *   **The ability to resend the verification code.**
    *   **A new password form** that appears after successful verification.
*   **Email Verification:** New users are required to verify their email address before they can access the application. The verification page now includes a "Resend Code" button.
*   **Secure Authentication:** The application uses Laravel's built-in authentication services to ensure that user data is handled securely.
*   **Robust Email Validation:** The registration process now includes a `try...catch` block to handle email sending failures. If an invalid email is provided, the user is gracefully redirected back to the registration page with an error message.
*   **Google Account Validation:** The registration form now validates that the email address is a valid Google account, ensuring that users are registering with a `@gmail.com` or `@google.com` email address.

### 2.2. Database

*   **User and Counter Models:** The database includes tables for `users` and `counters`, with corresponding Eloquent models for easy data management.
*   **Database Seeding:** The database is seeded with initial data for both `users` and `counters`, making it easy to test and develop the application.
*   **Famous Filipino Programmers:** The `users` table is populated with a list of 10 famous Filipino programmers, each with a default password of `password`.

### 2.3. Routing and Navigation

*   **Dashboard Route:** A new `/dashboard` route has been created to serve as the main page for authenticated users.
*   **Redirects:** The application automatically redirects users to the `/dashboard` route after a successful login.
*   **Guest and Auth Middleware:** The application uses Laravel's middleware to ensure that authenticated users are directed to the correct pages, while guests are restricted to the login and registration pages.
*   **Profile Routes:** A complete set of routes for user profile management has been implemented, including routes for displaying, updating, and deleting a user's profile.

### 2.4. Interactive Dashboard

*   **Real-time Counter:** The dashboard now includes a simple counter that can be incremented by the user in real-time, without a full page refresh. This is achieved using AJAX to send an asynchronous request to the server and update the counter on the page with the response.

### 2.5. User Profile Management

*   **Profile Information:** Users can update their personal information, including their name and email address.
*   **Email Verification:** When a user updates their email address, they are required to re-verify it. A new verification link is sent to the new email address.
*   **Password Updates:** Users can securely update their password from their profile page.
*   **Account Deletion:** Users have the option to delete their account, which will remove all of their data from the application.

### 2.6. UI/UX

*   **Unified Layout:** The dashboard and profile pages now share the same component-based layout and Tailwind CSS structure, providing a consistent and modern user experience.

## 3. Current Implementation Plan

*   **Objective:** To prevent the "Your email address is unverified" message from appearing on the profile page, since email verification is already handled during registration.
*   **Steps Taken:**
    1.  **Removed `MustVerifyEmail` Contract:** The `implements MustVerifyEmail` contract was removed from the `app/Models/User.php` file.
    2.  **Updated Fillable Attributes:** The `$fillable` array in the `User` model was updated to include `middle_name` and `email_verified_at` and to remove `verification_code`.
