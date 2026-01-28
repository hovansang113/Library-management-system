<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/css/member/MemberDashborad.css">
</head>
<body>
<div class="container">

    <section class="card">
        <h2>Current Loans</h2>

        <div class="info-box">
            📚 You currently have <b>5 books</b> on loan.
            <a href="current-loans.php" class="btn-view">View all</a>
        </div>

        <table>
            <tr>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>Book A</td>
                <td>1/1/2026</td>
                <td>4/2/2026</td>
                <td><span class="status borrowing">Borrowing</span></td>
            </tr>
        </table>
    </section>

    <section class="card">
        <h2>Borrowing History</h2>

        <div class="info-box">
            🕒 Listing history of your past borrowed books.
            <a href="borrowing-history.php" class="btn-view">View all</a>
        </div>

        <table>
            <tr>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>Book A</td>
                <td>1/1/2026</td>
                <td>4/2/2026</td>
                <td><span class="status returned">Return</span></td>
            </tr>
        </table>
    </section>

</div>
</body>
</html>

