<?php

namespace App\Applications\IPs\DTO;

class IPDTO
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $IP;
    /**
     * @var int
     */
    private $nbVisit;
    /**
     * @var \DateTime
     */
    private $lastVisit;
    /**
     * @var string
     */
    private $IPURL;

    public function __construct(
    int $id,
    string $IP,
    int $nbVisit,
    \DateTime $lastVisit,
    string $IPURL
)
{
    $this->id = $id;
    $this->IP = $IP;
    $this->nbVisit = $nbVisit;
    $this->lastVisit = $lastVisit;
    $this->IPURL = $IPURL;
}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'IP' => $this->IP,
            'nbVisit' => $this->nbVisit,
            'lastVisit' => $this->lastVisit,
            'IPURL' => $this->IPURL
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIP(): string
    {
        return $this->IP;
    }

    /**
     * @param string $IP
     */
    public function setIP(string $IP): void
    {
        $this->IP = $IP;
    }

    /**
     * @return int
     */
    public function getNbVisit(): int
    {
        return $this->nbVisit;
    }

    /**
     * @param int $nbVisit
     */
    public function setNbVisit(int $nbVisit): void
    {
        $this->nbVisit = $nbVisit;
    }

    /**
     * @return \DateTime
     */
    public function getLastVisit(): \DateTime
    {
        return $this->lastVisit;
    }

    /**
     * @param \DateTime $lastVisit
     */
    public function setLastVisit(\DateTime $lastVisit): void
    {
        $this->lastVisit = $lastVisit;
    }

    /**
     * @return string
     */
    public function getIPURL(): string
    {
        return $this->IPURL;
    }

    /**
     * @param string $IPURL
     */
    public function setIPURL(string $IPURL): void
    {
        $this->IPURL = $IPURL;
    }
}