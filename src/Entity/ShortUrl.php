<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShortLinkRepository")
 * @ORM\Table(name="urls_table")
 */
class ShortUrl implements \JsonSerializable
{
    /**
     * identifier, which will also be the decoded shortUrl
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * the original 'long' url
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=1000, name="original_url")
     */
    private $url;

    /** 
     * creation date added for potential expiracy purposes
     * @ORM\Column(type="datetime", name="creation_date")
     */
    private $creationDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $date): self
    {
        $this->creationDate = $date;
        return $this;
    }
}
