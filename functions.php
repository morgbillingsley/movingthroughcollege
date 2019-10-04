<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '/var/www/html/vendor/autoload.php';
    // Theme Support
    add_theme_support('post-thumbnails');

    // Hooks
    add_action('admin_post_nopriv_contact', 'contact_proc');
    add_action('admin_post_contact', 'contact_proc');

    // Functions
    function contact_proc()
    {
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
        $plain = "Name: $fname $lname\nEmail: $email\nPhone: $phone\nPacking: $packing\nService: $service\nTruck: $truck\nMessage: $message";
        sendEmail($to, $subject, $html, $plain);

        // Redirect to homepage
        wp_redirect('http://movingthroughcollege.com/');
    }
    
    function pushover($message)
    {
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

    function sendEmail($to, $subject, $html, $plain)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.yandex.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'rubendrotz@movingthroughcollege.com';                     // SMTP username
            $mail->Password   = 'drotz498';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTSSL;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('rubendrotz@movingthroughcollege.com', 'Ruben Drotzmann');
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->AltBody = $plain;

            $mail->send();
        } catch (Exception $e) {
            die($e);
        }
    }
