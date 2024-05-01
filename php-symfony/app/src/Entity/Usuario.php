<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Esta propiedad representa una relación de uno a muchos con la entidad Evento.
    // Un usuario puede ser anfitrión de muchos eventos, pero un evento solo puede tener un anfitrión.
    #[ORM\OneToMany(targetEntity: Evento::class,mappedBy: 'anfitrion')]
    private Collection $eventosAnfitrion;

    // Esta propiedad representa una relación de muchos a muchos con la entidad Evento.
    // Un usuario puede participar en muchos eventos y un evento puede tener muchos usuarios participantes.
    #[ORM\ManyToMany(targetEntity: Evento::class,inversedBy: 'usuarios')]
    #[ORM\JoinTable(name: 'participantes_eventos')]
    private Collection $eventosParticipantes;

    public function __construct(){
        $this->eventosAnfitrion = new ArrayCollection();
    }

    /**
     * @return Collection<int,Evento>
     */
    public function getEventos():Collection
    {
        return   $this->eventosAnfitrion;
    }


    public function addEvento(Evento $evento): static
    {
        if($this->eventosAnfitrion->contains($evento)){
            $this->eventosAnfitrion->add($evento);
            $evento->addUsuario($this);
        }
        return $this;
    }

    public function removeEvento(Evento $evento): static
    {
        if ($this->eventosAnfitrion->removeElement($evento)) {
            $evento->removeUsuario($this);
        }
        return $this;
    }

    #[ORM\Column(length: 50,nullable: false)]
    private string $nick;

    #[ORM\Column(length: 50)]
    private string $nombre;

    #[ORM\Column(length: 50)]
    private string $apellidos;

    #[ORM\Column(length: 50)]
    private string $email;

    #[ORM\Column(length: 50)]
    private string $karma;

    #[ORM\Column(length: 50)]
    private string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNick(): string
    {
        return $this->nick;
    }

    public function setNick(string $nick): void
    {
        $this->nick = $nick;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getKarma(): string
    {
        return $this->karma;
    }

    public function setKarma(string $karma): void
    {
        $this->karma = $karma;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function __toString(): string
    {
        return $this->nombre;
    }


}
