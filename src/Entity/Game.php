<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 * @Vich\Uploadable
 */
class Game extends AbstractDisplayableEntity
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $history;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="date")
     * @Assert\Type(\DateTimeInterface::class)
     */
    private $releaseDate;

    /**
     * @var integer
     * @ORM\Column(type="smallint")
     * @Assert\Positive
     */
    private $nbPlayers;

    /**
     * @var License
     * @ORM\ManyToOne(targetEntity=License::class, inversedBy="games", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $license;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity=Console::class, inversedBy="games", fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"name"="DESC"})
     */
    private $consoles;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="games", fetch="EXTRA_LAZY")
     */
    private $genres;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=GameItem::class, mappedBy="game", cascade={"all"}, fetch="EXTRA_LAZY")
     */
    private $gameItems;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=GameCharacter::class, mappedBy="game", cascade={"all"}, fetch="EXTRA_LAZY")
     */
    private $gameCharacters;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $copiesSold;

    /**
     * @Vich\UploadableField(mapping="games_images", fileNameProperty="thumbnail")
     * @var File|null
     */
    private $uploadThumbnail;

    /**
     * @Vich\UploadableField(mapping="licenses_images", fileNameProperty="logo")
     * @var File|null
     */
    private $uploadLogo;

    public function __construct()
    {
        $this->consoles = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->gameItems = new ArrayCollection();
        $this->gameCharacters = new ArrayCollection();
    }

    /**
     * Get id value
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get history value
     *
     * @return string|null
     */
    public function getHistory(): ?string
    {
        return $this->history;
    }

    /**
     * Set history value
     *
     * @param string $history
     * @return self
     */
    public function setHistory(string $history): self
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get release date value
     *
     * @return \DateTimeInterface|null
     */
    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    /**
     * Set release date value
     *
     * @param \DateTimeInterface $releaseDate
     * @return self
     */
    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get maximum player numbers value
     *
     * @return integer|null
     */
    public function getNbPlayers(): ?int
    {
        return $this->nbPlayers;
    }

    /**
     * Set maximum player numbers value
     *
     * @param integer $nbPlayers
     * @return self
     */
    public function setNbPlayers(int $nbPlayers): self
    {
        $this->nbPlayers = $nbPlayers;

        return $this;
    }

    /**
     * Get license value
     *
     * @return License|null
     */
    public function getLicense(): ?License
    {
        return $this->license;
    }

    /**
     * Set license value
     *
     * @param License $license
     * @return self
     */
    public function setLicense(License $license): self
    {
        $this->license = $license;

        return $this;
    }

    /**
     * Get list of consoles
     * 
     * @return Collection|Console[]
     */
    public function getConsoles(): Collection
    {
        return $this->consoles;
    }

    /**
     * Add a console of collection
     *
     * @param Console $console
     * @return self
     */
    public function addConsole(Console $console): self
    {
        if (!$this->consoles->contains($console)) {
            $this->consoles[] = $console;
        }

        return $this;
    }

    /**
     * Remove a console of collection
     *
     * @param Console $console
     * @return self
     */
    public function removeConsole(Console $console): self
    {
        if ($this->consoles->contains($console)) {
            $this->consoles->removeElement($console);
        }

        return $this;
    }

    /**
     * Get list of genre
     * 
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    /**
     * Add a genre of collection
     *
     * @param Genre $genre
     * @return self
     */
    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    /**
     * Remove a genre of collection
     *
     * @param Genre $genre
     * @return self
     */
    public function removeGenre(Genre $genre): self
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
        }

        return $this;
    }

    /**
     * Get list of games items
     * 
     * @return Collection|GameItem[]
     */
    public function getGameItems(): Collection
    {
        return $this->gameItems;
    }

    /**
     * Add a game item of collection
     *
     * @param GameItem $gameItem
     * @return self
     */
    public function addGameItem(GameItem $gameItem): self
    {
        if (!$this->gameItems->contains($gameItem)) {
            $this->gameItems[] = $gameItem;
            $gameItem->setGame($this);
        }

        return $this;
    }

    /**
     * Remove a game item of collection
     *
     * @param GameItem $gameItem
     * @return self
     */
    public function removeGameItem(GameItem $gameItem): self
    {
        if ($this->gameItems->contains($gameItem)) {
            $this->gameItems->removeElement($gameItem);
            // set the owning side to null (unless already changed)
            if ($gameItem->getGame() === $this) {
                $gameItem->setGame(null);
            }
        }

        return $this;
    }

    /**
     * Get list of games characters
     * 
     * @return Collection|GameCharacter[]
     */
    public function getGameCharacters(): Collection
    {
        return $this->gameCharacters;
    }

    /**
     * Add a game character of collection
     *
     * @param GameCharacter $gameCharacter
     * @return self
     */
    public function addGameCharacter(GameCharacter $gameCharacter): self
    {
        if (!$this->gameCharacters->contains($gameCharacter)) {
            $this->gameCharacters[] = $gameCharacter;
            $gameCharacter->setGame($this);
        }

        return $this;
    }

    /**
     * Remove a game character of collection
     *
     * @param GameCharacter $gameCharacter
     * @return self
     */
    public function removeGameCharacter(GameCharacter $gameCharacter): self
    {
        if ($this->gameCharacters->contains($gameCharacter)) {
            $this->gameCharacters->removeElement($gameCharacter);
            // set the owning side to null (unless already changed)
            if ($gameCharacter->getGame() === $this) {
                $gameCharacter->setGame(null);
            }
        }

        return $this;
    }

    /**
     * Get copies sold value
     *
     * @return integer|null
     */
    public function getCopiesSold(): ?int
    {
        return $this->copiesSold;
    }

    /**
     * Set copies sold value
     *
     * @param integer $copiesSold
     * @return self
     */
    public function setCopiesSold(int $copiesSold): self
    {
        $this->copiesSold = $copiesSold;

        return $this;
    }

    /**
     * Set logo file value
     *
     * @param File|null $uploadLogo
     * @return void
     */
    public function setUploadLogo(?File $uploadLogo): void
    {
        $this->uploadLogo = $uploadLogo;

        if($this->uploadLogo){
            $this->setUpdateAt(new \Datetime());
        }
    }

    /**
     * Get logo file value
     *
     * @return File|null
     */
    public function getUploadLogo(): ?File
    {
        return $this->uploadLogo;
    }

    /**
     * Get logo value
     *
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * Set logo value
     *
     * @param string|null $logo
     * @return self
     */
    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}
