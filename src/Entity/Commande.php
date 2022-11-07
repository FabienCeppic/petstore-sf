<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 65, nullable: true)]
    private ?string $etat_commande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facture_fichier = null;

    #[ORM\ManyToMany(targetEntity: Article::class)]
    private Collection $article;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $client = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandesHasArticles::class)]
    private Collection $commandesHasArticles;

    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->commandesHasArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getEtatCommande(): ?string
    {
        return $this->etat_commande;
    }

    public function setEtatCommande(?string $etat_commande): self
    {
        $this->etat_commande = $etat_commande;

        return $this;
    }

    public function getFactureFichier(): ?string
    {
        return $this->facture_fichier;
    }

    public function setFactureFichier(?string $facture_fichier): self
    {
        $this->facture_fichier = $facture_fichier;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        $this->article->removeElement($article);

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, CommandesHasArticles>
     */
    public function getCommandesHasArticles(): Collection
    {
        return $this->commandesHasArticles;
    }

    public function addCommandesHasArticle(CommandesHasArticles $commandesHasArticle): self
    {
        if (!$this->commandesHasArticles->contains($commandesHasArticle)) {
            $this->commandesHasArticles->add($commandesHasArticle);
            $commandesHasArticle->setCommande($this);
        }

        return $this;
    }

    public function removeCommandesHasArticle(CommandesHasArticles $commandesHasArticle): self
    {
        if ($this->commandesHasArticles->removeElement($commandesHasArticle)) {
            // set the owning side to null (unless already changed)
            if ($commandesHasArticle->getCommande() === $this) {
                $commandesHasArticle->setCommande(null);
            }
        }

        return $this;
    }
}
