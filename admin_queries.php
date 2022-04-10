<?php
include('./apis/config.php');
$read_queries = "SELECT * FROM queries";
$response = mysqli_query($conn, $read_queries) or die(mysqli_error($conn));
$available_queries = mysqli_fetch_all($response, MYSQLI_ASSOC);

if (mysqli_num_rows($response) == 0) {
    echo "
        <div class='text-center'>
            <h2>No queries registered yet. Good job!</h2>
        </div>
    ";
} else {
    echo "
        <div class='mt-2'>
            <div class='section-heading text-center'>
                <h2>Queries</h2>
                <h6>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestias, magnam?</h6>
            </div>
        </div>
    ";

    echo "
        <form action='./api/admin-manage.php' class='queries' method='POST'>
    ";

    echo "
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Reply</th>
                    </tr>
                </thead>
                <tbody>
    ";

    for ($i = 0; $i < sizeof($available_queries); $i++) {
        $query_id = $available_queries[$i]["qid"];
        $user_name = $available_queries[$i]["name"];
        $user_email = $available_queries[$i]["email"];
        $message = $available_queries[$i]["query"];
        $previous_reply = $available_queries[$i]["reply"];
        echo "
            <tr>
                <td>$user_name</td>
                <td>$user_email</td>
                <td>$message</td>
        ";

        echo "
                <input type='hidden' value='$query_id' name='query_ids[]'>
                <td>
                    <textarea type='text' class='form-control' maxlength='100' placeholder='No reply send yet!' cols='30' rows='3' name='replies[]'>$previous_reply</textarea>
                </td>
            </tr>
        ";
    }

    echo "
                    </tbody>
                </table>
            <div class='text-center'>
                <button type='submit' class='btn btn-info w-50' name='send_replies'>Update Replies</button>
            </div>
        </form>
    ";
}
