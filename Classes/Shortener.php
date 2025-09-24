<?php
class Shortener
{
    private $pdo;
    private $baseUrl;

    public function __construct($pdo, $baseUrl = "http://veyran.net/")
    {
        $this->pdo = $pdo;
        $this->baseUrl = $baseUrl;
    }

    public function shorten($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Ungültige URL");
        }

        $code = $this->generateCode();
        $this->addUrl($url, $code);

        return $this->baseUrl . $code;
    }

    private function addUrl($url, $short)
    {

        $stmt = $this->pdo->prepare(
            "INSERT INTO url (url, short) VALUES (:url, :short)"
        );
        $stmt->execute([
            ":url" => $url,
            ":short" => $short
        ]);
    }

    private function generateCode()
    {
        return substr(md5(uniqid((string)rand(), true)), 0, 6);
    }

    public function resolve($short)
    {
        $stmt = $this->pdo->prepare(
            "SELECT url FROM url WHERE short = :short LIMIT 1"
        );
        $stmt->execute([":short" => $short]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && isset($row['url'])) {
            return $row['url'];
        } else {
            return null;
        }
    }
}
