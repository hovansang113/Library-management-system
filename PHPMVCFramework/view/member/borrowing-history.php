<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowing History</title>
    <link rel="stylesheet" href="/css/member/MemberDashborad.css">
</head>
<body>

<div class="container">

    <section class="card">
        <h2>Borrowing History</h2>

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

            <tr>
                <td>Book D</td>
                <td>1/1/2026</td>
                <td>4/2/2026</td>
                <td><span class="status late">Late Return</span></td>
            </tr>
        </table>

        <div class="pagination">
            <a href="#">‹ Prev</a>
            <a class="active">1</a>
            <a>2</a>
            <a>3</a>
            <span>...</span>
            <a>Next ›</a>
        </div>

    </section>

</div>
</body>
</html>