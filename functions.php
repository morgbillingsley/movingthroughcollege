<?php
    // Theme Support
    add_theme_support('post-thumbnails');

    // Hooks
    add_action('admin_post_nopriv_contact', 'contact_proc');
    add_action('admin_post_contact', 'contact_proc');

    // Functions
    function contact_proc() {
        // Post data
        $fname = strval($_POST['fname']);
        $lname = strval($_POST['lname']);
        $email = strval($_POST['email']);
        $phone = strval($_POST['phone']);
        $packing = strval($_POST['packing']);
        $service = strval($_POST['service']);
        $truck = ($_POST['truck-size'] != '0') ? strval($_POST['truck-size']) . 'ft' : 'n/a';
        $message = strval($_POST['message']);
        $datetime = date('Y-m-d h:i:sa');
        $ip = strval($_SERVER['REMOTE_ADDR']);
        $browser = get_browser(null, true);
        $client = strval($browser['parent']);
        $os = strval($browser['platform']);

        $table = 'contacts';
        $data = array(
            'first_name' => $fname,
            'last_name' => $lname,
            'email' => $email,
            'phone' => $phone,
            'packing' => $packing,
            'service' => $service,
            'truck' => $truck,
            'message' => $message,
            'datetime' => $datetime,
            'ip_address' => $ip,
            'browser' => $client,
            'operating_system' => $os
        );
        $format = array('%s','%s','%s','%s','%s','%s','%s','%s','%s');

        global $wpdb;
        $wpdb->insert($table, $data, $format);

        // Send notification
        $message = "A new contact form was submitted by {$fname} {$lname} for {$service}.";
        pushover($message);

        // Send Email
        $to = 'morgan@morganbillingsley.com';
        $subject = 'New Estimate Request';
        $html = "<table>
            <tr>
                <th>Name</th>
                <td>$fname $lname</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>$email</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>$phone</td>
            </tr>
            <tr>
                <th>Packing</th>
                <td>$packing</td>
            </tr>
            <tr>
                <th>Service</th>
                <td>$service</td>
            </tr>
            <tr>
                <th>Truck</th>
                <td>$truck</td>
            </tr>
            <tr>
                <th>Message</th>
                <td>$message</td>
            </tr>
            <tr>
                <th>ipv4</th>
                <td>$ip</td>
            </tr>
        </table>";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $html, $headers);

        // Redirect to homepage
        wp_redirect('http://movingthroughcollege.com/');
    }
    
    function pushover($message) {
        $params = array(
            "token" => "adcuf77pykadwm6zyj14b9vfyhhy84",
            "user" => "u4r33u7gk4txdjfcv1m2qxjnwrmag4",
            "message" => $message
        );
        $po = curl_init("https://api.pushover.net/1/messages.json");
        curl_setopt($po, CURLOPT_POSTFIELDS, $params);
        $result = curl_exec($po);
        if (curl_errno($po)) {
            error_log('Failed to send pushover notification');
        }
        curl_close($po);
    }

    function sendgrid($to, $subject, $body) {
        $apikey = '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';
        $url = 'https://api.sendgrid.com/v3/mail/send';
        $params = "{'personalizations': [{'to': [{'email': '$to'}]}],'from': {'email': 'rubendrotz@movingthroughcollege.com'},'subject': '$subject','content': [{'type': 'text/html', 'value': $html}]}";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer $apikey", 'Content-Type: application/json'));
        curl_setopt ($curl, CURLOPT_POST, true);
        curl_setopt ($curl, CURLOPT_POSTFIELDS, $params);
        
        $response = curl_exec($curl);
        curl_close($curl);
    }
?>