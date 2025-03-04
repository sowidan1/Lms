<!DOCTYPE html>
<html>

<head>
    <title>Subscription Started</title>
</head>

<body>
    <h1>Welcome to Your New Course!</h1>
    <p>Dear {{ $user->name }},</p>
    <p>We’re excited to let you know that your subscription to <strong>{{ $course->title }}</strong> has started successfully!</p>

    <h2>Course Details</h2>
    <ul>
        <li><strong>Title:</strong> {{ $course->title }}</li>
        <li><strong>Description:</strong> {{ $course->description }}</li>
        <li><strong>Price:</strong> ${{ number_format($course->price, 2) }}/month</li>
        <li><strong>Instructor:</strong> {{ $course->instructor->name }}</li>
    </ul>

    <p>You can now access the course content anytime. Enjoy your learning journey!</p>

    <p>Best regards,<br>Your LMS Team</p>
</body>

</html>
