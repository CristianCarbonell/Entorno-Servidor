<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventoRepository::class)]
class Evento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Esta propiedad representa una relación de muchos a muchos con la entidad Usuario.
    // Un evento puede tener muchos usuarios participantes y un usuario puede participar en muchos eventos.
    #[ORM\ManyToMany(targetEntity: Usuario::class,mappedBy: 'eventosParticipantes')]
    private Collection $usuarios;

    // Esta propiedad representa una relación de muchos a uno con la entidad Usuario.
    // Un evento puede tener un único anfitrión (usuario), pero un usuario puede ser anfitrión de muchos eventos.
    #[ORM\ManyToOne(targetEntity: Usuario::class,inversedBy: 'eventosAnfitrion')]
    private ?Usuario $anfitrion = null;


    public function __construct(){
        $this->usuarios = new ArrayCollection();
    }

    /**
     * @return Collection<int,Usuario>
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario): static
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios->add($usuario);
            $usuario->addEvento($this);
        }
        return $this;
    }

    public function removeUsuario(Usuario $usuario): static
    {
        if ($this->usuarios->removeElement($usuario)) {
            $usuario->removeEvento($this);
        }
    }

    // Propiedades de la entidad Evento y su mapeo a la base de datos.

    #[ORM\Column(length: 100,nullable: false)]
    private string $nombre;
    #[ORM\Column(length: 255)]
    private string $descripcion;
    #[ORM\Column(length: 50)]
    private string $ubicacion;
    #[ORM\Column(length: 50)]
    private string $terreno;
    #[ORM\Column(length: 30)]
    private DateTime $fecha;
    #[ORM\Column(length: 50)]
    private string $tipo;
    #[ORM\Column(length: 300)]
    private string $imagen;
    #[ORM\Column(type: "integer")]
    private int $especies;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnfitrion(): ?Usuario
    {
        return $this->anfitrion;
    }

    public function setAnfitrion(?Usuario $anfitrion): void
    {
        $this->anfitrion = $anfitrion;
    }

    public function getEspecies(): int
    {
        return $this->especies;
    }

    public function setEspecies(int $especies): void
    {
        $this->especies = $especies;
    }




    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getUbicacion(): string
    {
        return $this->ubicacion;
    }

    public function setUbicacion(string $ubicacion): void
    {
        $this->ubicacion = $ubicacion;
    }



    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getTerreno(): string
    {
        return $this->terreno;
    }

    public function setTerreno(string $terreno): void
    {
        $this->terreno = $terreno;
    }



    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }



}
