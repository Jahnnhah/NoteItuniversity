<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Header Example</title>
 <style>
    /* styles.css */

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.main-header {
    background-color: #101A45; /* Dark blue color */
    color: #fff;
    padding: 20px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
}

.container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.logo a {
    color: #00CFFF; /* Light blue color */
    font-size: 24px;
    text-decoration: none;
    font-weight: bold;
}

.nav-links ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.nav-links ul li {
    margin-left: 20px;
}

.nav-links ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    padding: 8px 16px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.nav-links ul li a:hover {
    background-color: #00CFFF; /* Light blue color */
}

.cta-button .btn {
    background-color: #00CFFF; /* Light blue color */
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.cta-button .btn:hover {
    background-color: #007BFF; /* Darker blue color for hover effect */
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
        text-align: center;
    }

    .nav-links ul {
        flex-direction: column;
    }

    .nav-links ul li {
        margin: 10px 0;
    }

    .cta-button {
        margin-top: 10px;
    }
}

</style>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="#">NOTES</a>
            </div>
            <nav class="nav-links">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
            <div class="cta-button">
                <a href="#" class="btn">Get Started</a>
            </div>
        </div>
    </header>
</body>
</html>
