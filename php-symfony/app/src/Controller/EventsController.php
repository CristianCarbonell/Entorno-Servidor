<?php

namespace App\Controller;

use App\Entity\Evento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    // Inyección de dependencias del EntityManager de Doctrine
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    // Ruta para listar todos los eventos
    #[Route('/events', name: 'app_event')]
    public function listEvents(): Response
    {
        // Obtiene todos los eventos de la base de datos
        $events = $this->em->getRepository(Evento::class)->findAll();

        // Renderiza la plantilla con los eventos
        return $this->render('events/listEvents.html.twig', [
            'eventos' => $events,
        ]);
    }

    // Ruta para crear eventos
    #[Route('/events/create', name: 'event_create')]
    public function create(): Response
    {
        // Generamos tres eventos
        for ($i = 1; $i <= 3; $i++) {
            $evento = new Evento();

            $fecha = new \DateTime();
            $fecha->modify('+' . $i . ' day');

            // Establecer los valores de las propiedades del evento
            $evento->setNombre('Nombre del evento ' . $i);
            $evento->setDescripcion('Descripción del evento ' . $i);
            $evento->setUbicacion('Ubicación del evento ' . $i);
            $evento->setTerreno('Tipo de terreno ' . $i);
            $evento->setFecha($fecha);
            $evento->setTipo('Tipo de evento ' . $i);
            // Generar un nombre de archivo único para la imagen
            $imageName = 'evento_' . uniqid() . '.jpg';
            // Guardar la imagen en el directorio public/images
            $imagePath = 'images/' . $imageName;
            $evento->setImagen($imagePath);
            $fileSystem = new \Symfony\Component\Filesystem\Filesystem();
            // Copia la imagen desde la URL generada aleatoriamente a la ruta local especificada
            $fileSystem->copy('https://picsum.photos/200/300?random=' . rand(), $imagePath);
            $evento->setEspecies(rand(1, 10));

            // Persiste y guarda el evento en la base de datos
            $this->em->persist($evento);
            $this->em->flush();
        }

        // Retorna una respuesta exitosa
        return new Response('Los eventos han sido creados con éxito');
    }

    // Ruta para mostrar un evento específico
    #[Route('/events/{id}', name: 'event_show')]
    public function show(int $id): Response
    {
        // Obtiene el evento de la base de datos
        $event = $this->em->getRepository(Evento::class)->find($id);

        // Renderiza la plantilla con el evento
        return $this->render('events/detailEvent.html.twig',[
            'event' => $event,
        ]);
    }

    // Ruta para eliminar un evento
    #[Route('/events/delete/{id}', name: 'event_delete')]
    public function delete(int $id): Response
    {
        // Obtiene el evento de la base de datos y lo elimina
        $event = $this->em->getRepository(Evento::class)->find($id);
        $this->em->remove($event);
        $this->em->flush();

        // Redirige a la página principal
        return $this->redirectToRoute('app_main');
    }

    // Ruta para editar un evento
    #[Route('/events/edit/{id}', name: 'event_edit')]
    public function edit(int $id): Response
    {
        // Obtiene el evento de la base de datos y actualiza sus propiedades
        $event = $this->em->getRepository(Evento::class)->find($id);
        $event->setNombre('Nombre actualizado');
        $event->setFecha(new \DateTime('2024-04-20'));

        // Guarda los cambios en la base de datos
        $this->em->flush();

        // Redirige a la página de detalles del evento
        return $this->redirectToRoute('event_show', ['id' => $id]);
    }
}
