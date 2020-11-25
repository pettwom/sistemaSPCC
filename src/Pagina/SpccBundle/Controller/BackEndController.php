<?php

namespace Pagina\SpccBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Pagina\SpccBundle\Models\Document;
use Doctrine\ORM\EntityRepository;
use Pagina\SpccBundle\Entity\Slider;
use Pagina\SpccBundle\Entity\News;
use Pagina\SpccBundle\Entity\Spcc;
use Pagina\SpccBundle\Entity\Comments;
use Pagina\SpccBundle\Entity\Config;
use Pagina\SpccBundle\Entity\Release;
use Pagina\SpccBundle\Entity\TypeGallery;
use Pagina\SpccBundle\Entity\Link;
use Pagina\SpccBundle\Entity\Gallery;

class BackEndController extends Controller
 {
    function __construct() {

    }
    //***************************.

    //SLIDER
    //***************************

    public function ListSliderAction()
 {
        $message = '';
        $respuesta = [];
        $configuration = [];
        $configuration = $this->configuracion();
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Slider' );

        $r = $q->createQueryBuilder( 's' )
        ->select( 's.imageSlider, s.state' )
        // ->where( "s.state = '1'" )
        //->setMaxResults( $configuration[0]['sliderQuantity'] )
        ->distinct()
        ->getQuery();
        $result = $r->getResult();
        if ( !$result ) {
            throw  new \Exception( 'No se encontraron Slider almacenados.' );
        }

        if ( sizeof( $result ) <= 0 ) {
            $respuesta = array(
                'ok'=> false,
                'message'=> 'Se tiene '.sizeof( $result ).' datos Registrados'
            );
        }
        $respuesta = json_encode( $result );

        dump( $respuesta );
        die;

        //$roles = $em->getRepository( 'SpccCertificadoBundle:Rol' )->findOneBy( array( 'id' => $this->session->get( 'rol_sel' ) ) );
        // return $this->render( 'SpccCertificadoBundle:Transcripcion:indexTrans.html.twig', array(
        //             'rol_id' => $roles->getId(),
        //             'tablaIndex' => $result['res'],
        //             'suma' => $result['count'],
        //             'rol' => $roles->getRoles() ) );
        //}
    }

    public function addSliderAction( Request $request ) {
        if ( $request->getMethod() === 'POST' ) {
            $em = $this->getDoctrine()->getManager();
            date_default_timezone_set( 'America/La_Paz' );
            $fechaActual = new \DateTime( date( 'Y-m-d' ) );
            $permitidos = ['jpg', 'png', 'jpeg'];
            $file = $this->upload( $request, 'file', 1000000, 'Slider', 'imageSlider', 'News', $permitidos );
            if ( $file['ok'] === true ) {
                try {
                    $state =
                    $em->getConnection()->beginTransaction();
                    $s = new Slider();
                    $s->setImageSlider( $file['message'] );
                    $s->setRegisterDate( $fechaActual );
                    $s->setUserId( 1 );
                    $s->setState( ( boolean ) 1 );
                    $em->persist( $s );
                    $em->flush();
                    $em->getConnection()->commit();
                    $respuesta = array(
                        'ok'=> true,
                        'message'=> 'Se almaceno correctamente el Slider con nombre '.$name
                    );
                    $respuesta = json_encode( $respuesta );
                    $response = new JsonResponse();
                    return $response->setData( array( 'res' => $respuesta ) );
                } catch( Error $e ) {
                    $em->getConnection()->rollback();
                    $respuesta = array(
                        'ok'=> false,
                        'message'=> 'Algo Salio Mal,\nVuelva a intentar!!'
                    );
                    $respuesta = json_encode( $respuesta );
                    throw  new Error( 'Algo no ha salido bien.', 400 );
                }
            }
        }
    }

    public function deleteSliderAction( Request $request ) {
        $sliderId = $request->get( 'idSlider' );
        $em = $this->getDoctrine()->getManager();
        try {
            $em->getConnection()->beginTransaction();
            $query = $em->getRepository( 'PaginaSpccBundle:Slider' )->findOneBy( array( 'id'=>$sliderId ) );
            $query->setState( ( boolean ) 0 );
            $em->persist( $query );
            $em->flush();
            $em->getConnection()->commit();
        } catch( Exception $e ) {
            throw  new \Error( 'Algo no ha salido bien. no se pudo actualizar el estado ', 500 );
        }
        $response = new JsonResponse();
        return $response->setData( array( 'res' => $sliderId ) );
    }

    //***************************
    //NEWS
    //***************************

    public function listNewsAction( Request $request ) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:News' )->findAll();
        if ( !$q ) {
            throw  new \Exception( 'No se encontraron noticias registradas.' );
        }

        if ( sizeof( $q ) <= 0 ) {
            $respuesta = array(
                'ok'=> false,
                'message'=> 'Se tiene '.sizeof( $q ).' noticias Registradas'
            );
        }
        $respuesta = array(
            'ok'=> true,
            'message'=> $q
        );
        $response = new JsonResponse();
        return $response->setData( $respuesta );
    }

    public function createNewsAction( Request $request ) {
        if ( $request->getMethod() === 'POST' ) {
            $title = $request->get( 'title' );
            $longNews = $request->get( 'longNews' );
            $dateNews = $request->get( 'dateNews' );
            $author = $request->get( 'authorNews' );
            $fileNews = $request->get( 'fileNews' );
            $shortNews = substr( strip_tags( $longNews ), 0, 255 );
            $em = $this->getDoctrine()->getManager();
            date_default_timezone_set( 'America/La_Paz' );
            $fechaActual = new \DateTime( date( 'Y-m-d' ) );
            $permitidos = ['jpg', 'png', 'jpeg'];
            $file = $this->upload( $request, 'fileNews', 1000000, 'News', 'pathImage', 'News', $permitidos );
            if ( $file['ok'] === true ) {
                try {
                    $em->getConnection()->beginTransaction();
                    $s = new News();
                    $s->setTitleNews( $title );
                    $s->setDateNews( $fechaActual );
                    $s->setShortNews( $shortNews );
                    $s->setLongNews( $longNews );
                    $s->setAuthorNews( $author );
                    $s->setRegisterDate( $fechaActual );
                    $s->setUserId( 1 );
                    $s->setState( ( boolean ) 1 );
                    $s->setPathImage( $file['message'] );
                    $em->persist( $s );
                    $em->flush();
                    $em->getConnection()->commit();
                    $respuesta = array(
                        'ok'=> true,
                        'message'=> 'Se almaceno correctamente la Noticia con el titulo '.$title
                    );
                    $respuesta = json_encode( $respuesta );
                    $response = new JsonResponse();
                    return $response->setData( array( 'res' => $respuesta ) );
                } catch( Error $e ) {
                    $em->getConnection()->rollback();
                    $respuesta = array(
                        'ok'=> false,
                        'message'=> 'Algo Salio Mal,\nVuelva a intentar!!'
                    );
                    $respuesta = json_encode( $respuesta );
                    throw  new Error( 'Algo no ha salido bien.', 400 );
                }
            }

        }
    }

    public function updateNewsAction( Request $request ) {

        $idNews = $request->get( 'idNews' );
        $title = $request->get( 'title' );
        $longNews = $request->get( 'longNews' );
        $dateNews = $request->get( 'dateNews' );
        $author = $request->get( 'authorNews' );
        $fileNews = $request->get( 'fileNews' );
        $shortNews = substr( strip_tags( $longNews ), 0, 255 );
        $em = $this->getDoctrine()->getManager();
        date_default_timezone_set( 'America/La_Paz' );
        $fechaActual = new \DateTime( date( 'Y-m-d' ) );
        try {
            $em->getConnection()->beginTransaction();
            $q = $em->getRepository( 'PaginaSpccBundle:News' )->findOneBy( array( 'id'=>$idNews ) );
            $q->setTitleNews( $title );
            $q->setDateNews( $fechaActual );
            $q->setShortNews( $shortNews );
            $q->setLongNews( $longNews );
            $q->setAuthorNews( $author );
            $q->setRegisterDate( $fechaActual );
            $q->setUserId( 1 );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=> $q
            );
            $response = new JsonResponse();
            return $response->setData( array( 'res' => $respuesta ) );
        } catch( Exception $e ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>'No se puedo actualizar, intentelo nuevamente!!! '
            );
            $response = new JsonResponse();
            return $response->setData( array( 'res' => $respuesta ) );
        }

    }

    public function delNewsAction( Request $request ) {
        $idNews = $request->get( 'idNews' );
        $em = $this->getDoctrine()->getManager();
        try {
            $em->getConnection()->beginTransaction();
            $q = $em->getRepository( 'PaginaSpccBundle:News' )->findOneBy( array( 'id'=>$idNews ) );
            if ( $q->getState() === true ) {
                $q->setState( false );
            } else {
                $q->setState( true );
            }
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=> $q
            );
            $response = new JsonResponse();
            return $response->setData( array( 'res' => $respuesta ) );

        } catch( Exception $e ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>'No se puedo actualizar, intentelo nuevamente!!! '. $e->getStatus()
            );
            $response = new JsonResponse();
            return $response->setData( array( 'res' => $respuesta ) );
        }
    }
    //***************************
    //COMMENTS
    //***************************

    public function commentsAction( Request $request ) {
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();
        $q = $em->getRepository( 'PaginaSpccBundle:Comments' )->findAll();
        if ( !$q ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'No se encontraron comentarios'
            );
            return $response->setData( $resultado );
        }
        $resultado = array(
            'ok'=>true,
            'message'=>$q
        );
        return $response->setData( $resultado );
        // return $response->setData( json_decode( $resultado ) );
    }

    public function commentAction( Request $request ) {
        $idComment = $request->get( 'idComment' );
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Comments' )->findOneBy( array( 'id'=>$idComment ) );
        if ( !$q ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'No se encontro el comentario'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        $resultado = array(
            'ok'=>true,
            'message'=>$q
        );
        $response = new JsonResponse();
        return $response->setData( $resultado );
    }

    public function toPostAction( Request $request ) {
        $idComment = $request->get( 'idComment' );
        $em = $this->getDoctrine()->getManager();
        try {
            $em->getConnection()->beginTransaction();
            $q = $em->getRepository( 'PaginaSpccBundle:Comments' )->findOneBy( array( 'id'=>$idComment ) );
            if ( $q->getStatus() === true ) {
                $q->setStatus( false );
            } else {
                $q->setStatus( true );
            }
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $resultado = array(
                'ok'=>true,
                'message'=>$q
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $resultado = array(
                'ok'=>false,
                'message'=> 'Se produjo el error '.$e->getMessage() .' con el codigo nro '. $e.getStatus()
            );

            $response = new JsonResponse();
            return $response->setData( $resultado );
        }

    }

    //***************************
    //SPCC
    //***************************

    public function listSpccAction( Request $request ) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Spcc' )->findAll();
        if ( !$q ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'No se encontro ningun registro'
            );
            $response = new JsonResponse();
            return $response->seData( $resultado );
        }
        $resultado = array(
            'ok'=>true,
            'message'=>$q
        );
        $response = new JsonResponse();
        return $response->setData( json_encode( $resultado ) );
    }

    public function oneSpccAction( Request $request ) {
        $idSpcc = $request->get( 'idSpcc' );
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Spcc' )->find( $idSpcc );
        if ( !$q ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'No se encontro el registro'
            );
            $response = new JsonResponse();
            return $response->seData( $resultado );
        }
        $resultado = array(
            'ok'=>true,
            'message'=>$q
        );
        $response = new JsonResponse();
        return $response->setData( json_encode( $resultado ) );
    }

    public function createSpccAction( Request $request ) {
        date_default_timezone_set( 'America/La_Paz' );
        $fechaActual = new \DateTime( date( 'Y-m-d H:i:s' ) );
        $mission = $request->get( 'mission' );
        $view = $request->get( 'view' );
        $objetive = $request->get( 'objetive' );
        $legalFramework = $request->get( 'legalFramework' );
        $userId = $request->get( 'userId' );

        $em = $this->getDoctrine()->getManager();
        try {
            $em->getConnection()->beginTransaction();
            $q = new Spcc();
            $q->setMission( $mission );
            $q->setView( $view );
            $q->setObjetive( $objetive );
            $q->setlegalFramework( $legalFramework );
            $q->setRegisterDate( $fechaActual );
            $q->setUserId( $userId );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $resultado = array(
                'ok'=>true,
                'message'=>$q
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        } catch( Exception $e ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'No se pudo registrar los datos'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
    }

    public function updateSpccAction( Request $request ) {
        $idSpcc = $request->get( 'idSpcc' );
        date_default_timezone_set( 'America/La_Paz' );
        $fechaActual = new \DateTime( date( 'Y-m-d H:i:s' ) );
        $mission = $request->get( 'mission' );
        $view = $request->get( 'view' );
        $objetive = $request->get( 'objetive' );
        $legalFramework = $request->get( 'legalFramework' );
        $userId = $request->get( 'userId' );

        $em = $this->getDoctrine()->getManager();
        try {
            $em->getConnection()->beginTransaction();
            $q = $em->getRepository( 'PaginaSpccBundle:Spcc' )->find( $idSpcc );
            $q->setMission( $mission );
            $q->setView( $view );
            $q->setObjetive( $objetive );
            $q->setlegalFramework( $legalFramework );
            $q->setRegisterDate( $fechaActual );
            $q->setUserId( $userId );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $resultado = array(
                'ok'=>true,
                'message'=>$q
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        } catch( Exception $e ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'No se pudo registrar los datos'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
    }

    public function delSpccAction( Request $request ) {
        $idSpcc = $request->get( 'idSpcc' );
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Spcc' )->find( $idSpcc );
        $em->getConnection()->beginTransaction();
        if ( !$q ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'No se encontro el Id'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        if ( $q->getState() === true ) {
            $q->setState( false );
        } else {
            $q->setState( true );

        }
        $em->persist( $q );
        $em->flush();
        $em->getConnection()->commit();
        $resultado = array(
            'ok'=>true,
            'message'=> $q->getState()
        );
        $response = new JsonResponse();
        return $response->setData( $resultado );
    }
    //***************************
    //CONFIG
    //***************************

    public function createConfigAction( Request $request ) {
        $em = $this->getDoctrine()->getManager();
        $config = $request->get( 'config' );
        $quantity = $request->get( 'quantity' );
        $em->getConnection()->beginTransaction();
        try {

        } catch( Exception $e ) {

        }

    }

    public function listConfigAction( Request $request ) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Configuration' )->findAll();
        if ( !$q ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>'No se encontraron datos'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
        $respuesta = array(
            'ok'=> true,
            'message'=>$q[0]
        );
        $response = new JsonResponse();
        return $response->setData( $respuesta );
    }

    public function updateConfigAction( Request $request ) {
        $idConfig = $request->get( 'idConfig' );
        $slider = $request->get( 'slider' );
        $news = $request->get( 'news' );
        $comments = $request->get( 'comments' );
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle' )->find( $idConfig );
        $em->getConnection()->beginTransaction();
        if ( !$q ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'No se encontro el Id'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );

        }
        $q->setSliderQuantity( $slider );
        $q->setNewsQuality( $news );
        $q->setCommentsQuantity( $comments );
        $em->persist( $q );
        $em->flush();
        $em->getConnection()->commit();
        $resultado = array(
            'ok'=>true,
            'message'=> $q->getState()
        );
        $response = new JsonResponse();
        return $response->setData( $resultado );
    }

    //***************************
    //RELEASE
    //***************************

    public function createReleaseAction( Request $request ) {
        $sw = 1;
        $userId = ( int )1;
        date_default_timezone_set( 'America/La_Paz' );
        $fechaActual = new \DateTime( date( 'Y-m-d H:i:s' ) );
        $release = is_null( $request->get( 'releases' ) ) ? $sw = 0 : $request->get( 'releases' );
        $acceptance = is_null( $request->get( 'acceptance' ) )?$sw = 0:$request->get( 'acceptance' );
        // dump( $release );
        // dump( $authorization );
        // dump( $sw );
        // die;
        if ( $sw === 0 ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>'Debe llenar los campos marcados obligatorios'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
        //$sw = 1;
        $em = $this->getDoctrine()->getManager();
        try {
            $em->getConnection()->beginTransaction();
            $q = new Release();
            $q->setReleases( $release );
            $q->setAcceptance( $acceptance );
            $q->setStatus( ( boolean )  1 );
            $q->setRegisterDate( $fechaActual );
            $q->setUserId( $userId );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=>'Se creo correctamente el comunicado'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $respuesta = array(
                'ok'=> false,
                'message'=>'Se genero el error nro. ' . $e->getStatus() . ' - ' . $e.getMessage()
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
    }

    public function listReleaseAction( Request $request ) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Release' )->findAll();
        if ( !$q ) {
            $resultado = array(
                'ok'=> false,
                'message'=>'No Existen Comunicados disponibles'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        $resultado = array(
            'ok'=> true,
            'message'=>$q
        );
        $response = new JsonResponse();
        return $response->setData( $resultado );
    }

    public function updateReleaseAction( Request $request ) {
        $sw = 1;
        $userId = ( int )1;
        date_default_timezone_set( 'America/La_Paz' );
        $fechaActual = new \DateTime( date( 'Y-m-d H:i:s' ) );
        $releaseId = is_null( $request->get( 'releaseId' ) )?$sw = 0:$request->get( 'releaseId' );
        $releases = is_null( $request->get( 'releases' ) ) ? $sw = 0 : $request->get( 'releases' );
        $acceptance = is_null( $request->get( 'acceptance' ) )?$sw = 0:$request->get( 'acceptance' );
        $em = $this->getDoctrine()->getManager();
        if ( $sw === 0 ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>'Debe llenar los campos marcados obligatorios'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
        try {
            $em->getConnection()->beginTransaction();
            $q = $em->getRepository( 'PaginaSpccBundle:Release' )->find( $releaseId );
            $q->setReleases( $releases );
            $q->setAcceptance( $acceptance );
            $q->setRegisterDate( $fechaActual );
            $q->setUserId( $userId );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=>'Se creo correctamente el comunicado'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $respuesta = array(
                'ok'=> false,
                'message'=>'Se genero el error nro. ' . $e->getStatus() . ' - ' . $e.getMessage()
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
    }

    public function delReleaseAction( Request $request ) {
        $releaseId = $request->get( 'releaseId' );
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Release' )->find( $releaseId );
        if ( !$q ) {
            $resultado = array(
                'ok'=> false,
                'message'=>'No Existen Comunicados disponibles'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        try {
            $em->getConnection()->beginTransaction();
            if ( $q->getStatus() === true ) {
                $q->setStatus( false );
            } else {
                $q->setStatus( true );
            }
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=>'Se actualizo correctamente el comunicado'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $respuesta = array(
                'ok'=> false,
                'message'=>'Se genero el error nro. ' . $e->getStatus() . ' - ' . $e.getMessage()
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
    }
    //***************************
    //GALLERY
    //***************************

    public function createGalleryAction( Request $request ) {
        if ( $request->getMethod() === 'POST' ) {
            $em = $this->getDoctrine()->getManager();
            $sw = 1;
            date_default_timezone_set( 'America/La_Paz' );
            $fechaActual = new \DateTime( date( 'Y-m-d' ) );
            $ocupacionId = is_null( $request->get( 'ocupacionId' ) )?$sw = 0:$request->get( 'ocupacionId' );
            $type = is_null( $request->get( 'typeId' ) )?$sw = 0:$request->get( 'typeId' );
            $permitidos = ['jpg', 'png', 'jpeg', 'mp4'];
            $file = $this->upload( $request, 'file', 1000000, 'Gallery', 'imageGallery', 'Gallery', $permitidos );
            if ( $file['ok'] === true ) {
                try {
                    $em->getConnection()->beginTransaction();
                    $s = new Gallery();
                    $s->setImageGallery( $file['message'] );
                    $s->setOcupacionId( $ocupacionId );
                    $s->setTypeId( $type );
                    $s->setRegisterDate( $fechaActual );
                    $s->setUserId( 1 );
                    $s->setState( ( boolean ) 1 );
                    $em->persist( $s );
                    $em->flush();
                    $em->getConnection()->commit();
                    $respuesta = array(
                        'ok'=> true,
                        'message'=> 'Se almaceno correctamente en Galeria con el nombre '.$file['message']
                    );
                    $respuesta = json_encode( $respuesta );
                    $response = new JsonResponse();
                    return $response->setData( array( 'res' => $respuesta ) );
                } catch( Error $e ) {
                    $em->getConnection()->rollback();
                    $respuesta = array(
                        'ok'=> false,
                        'message'=> 'Algo Salio Mal,\nVuelva a intentar!!'
                    );
                    $respuesta = json_encode( $respuesta );
                    throw  new Error( 'Algo no ha salido bien.', 400 );
                }
            }
        }
    }

    public function listGalleryAction( Request $request ) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Gallery' )->findAll();
        if ( !$q ) {
            $resultado = array(
                'ok'=> false,
                'message'=>'No Existen archivos multimedia disponibles'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        $resultado = array(
            'ok'=> true,
            'message'=>$q
        );
        $response = new JsonResponse();
        return $response->setData( $resultado );
    }

    public function updateGalleryAction( Request $request ) {
        $sw = 1;
        $galleryId = is_null( $request->get( 'galleryId' ) )?$sw = 0:$request->get( 'galleryId' );
        $ocupacionId = is_null( $request->get( 'ocupacionId' ) )?$sw = 0:$request->get( 'ocupacionId' );
        $typeId = is_null( $request->get( 'typeId' ) )?$sw = 0:$request->get( 'typeId' );
        if ( $sw === 0 ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'Debe llenar los campos marcados como obligatorios'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        try {
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            $q = $em->getRepository( 'PaginaSpccBundle:Gallery' )->find( $galleryId );
            $q->setOcupacionId( $ocupacionId );
            $q->setTypeId( $typeId );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $resultado = array(
                'ok'=>true,
                'message'=>'Se actualizaron todos los datos'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $resultado = array(
                'ok'=>false,
                'message'=>'No se pudo actualizar los datos'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
    }

    public function delGalleryAction( Request $request ) {
        $sw = 1;
        $galleryId = is_null( $request->get( 'galleryId' ) )?$sw = 0:$request->get( 'galleryId' );
        if ( $sw == 0 ) {
            $resultado = array(
                'ok'=>false,
                'message'=>'Debe proporcionar el campo a eliminar'
            );
            $response = new JsonResponse;
            return $response->setData( $resultado );
        }

        $em = $this->getDoctrine()->getManager();
        try {
            $em->getConnection()->beginTransaction();
            $q = $em->getRepository( 'PaginaSpccBundle:Gallery' )->findOneBy( array( 'id'=>$galleryId ) );
            if ( $q->getState() == 1 ) {
                $q->setState( ( boolean ) 0 );
            } else {
                $q->setState( ( boolean ) 1 );
            }
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
        } catch( Exception $e ) {
            throw  new \Error( 'Algo no ha salido bien. no se pudo actualizar el estado ', 500 );
        }
        $response = new JsonResponse();
        return $response->setData( array( 'res' => $galleryId ) );
    }
    //***************************
    //TYPE
    //***************************

    public function createTypeAction( Request $request ) {
        $sw = 1;
        $userId = ( int )1;
        date_default_timezone_set( 'America/La_Paz' );
        $fechaActual = new \DateTime( date( 'Y-m-d H:i:s' ) );
        $em = $this->getDoctrine()->getManager();
        $type = is_null( $request->get( 'typeGallery' ) ) ? $sw = 0 : $request->get( 'typeGallery' );
        $q = $em->getRepository( 'PaginaSpccBundle:TypeGallery' )->findOneBy( array( 'type'=>$type ) );
        if ( $q ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>"El dato: {$type} ya se encuentra registrado"
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }

        if ( $sw === 0 ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>'Debe llenar los campos marcados obligatorios'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
        try {
            $em->getConnection()->beginTransaction();
            $q = new TypeGallery();
            $q->settype( $type );
            $q->setStatus( ( boolean )  1 );
            $q->setRegisterDate( $fechaActual );
            $q->setUserId( $userId );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=>'Se creo correctamente el tipo de galeria'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $respuesta = array(
                'ok'=> false,
                'message'=>'Se genero el error nro. ' . $e->getStatus() . ' - ' . $e.getMessage()
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
    }

    public function listTypeAction( Request $request ) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:TypeGallery' )->findAll();
        if ( !$q ) {
            $resultado = array(
                'ok'=> false,
                'message'=>'No Existen el tipo disponibles'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        $resultado = array(
            'ok'=> true,
            'message'=>$q
        );
        $response = new JsonResponse();
        return $response->setData( $resultado );
    }

    public function updateTypeAction( Request $request ) {
        $sw = 1;
        $userId = ( int )1;
        date_default_timezone_set( 'America/La_Paz' );
        $fechaActual = new \DateTime( date( 'Y-m-d H:i:s' ) );
        $typeId = is_null( $request->get( 'typeId' ) )?$sw = 0:$request->get( 'typeId' );
        $type = is_null( $request->get( 'type' ) ) ? $sw = 0 : $request->get( 'type' );

        $em = $this->getDoctrine()->getManager();
        if ( $sw === 0 ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>'Debe llenar los campos marcados obligatorios'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
        try {
            $em->getConnection()->beginTransaction();
            $q = $em->getRepository( 'PaginaSpccBundle:TypeGallery' )->find( $typeId );
            $q->setType( $type );
            $q->setRegisterDate( $fechaActual );
            $q->setUserId( $userId );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=>'Se creo correctamente el tipo'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $respuesta = array(
                'ok'=> false,
                'message'=>'Se genero el error nro. ' . $e->getStatus() . ' - ' . $e.getMessage()
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
    }

    public function delTypeAction( Request $request ) {
        $releaseId = $request->get( 'typeId' );
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:TypeGallery' )->find( $releaseId );
        if ( !$q ) {
            $resultado = array(
                'ok'=> false,
                'message'=>'No Existen tipo disponibles'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        try {
            $em->getConnection()->beginTransaction();
            if ( $q->getStatus() === true ) {
                $q->setStatus( false );
            } else {
                $q->setStatus( true );
            }
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=>'Se actualizo correctamente el comunicado'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $respuesta = array(
                'ok'=> false,
                'message'=>'Se genero el error nro. ' . $e->getStatus() . ' - ' . $e.getMessage()
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
    }
    //***************************
    //LINK
    //***************************

    public function createLinkAction( Request $request ) {
        $sw = 1;
        $userId = ( int )1;
        date_default_timezone_set( 'America/La_Paz' );
        $fechaActual = new \DateTime( date( 'Y-m-d H:i:s' ) );
        $em = $this->getDoctrine()->getManager();
        $linkTitle = is_null( $request->get( 'linkTitle' ) ) ? $sw = 0 : $request->get( 'linkTitle' );
        $descriptionLink = is_null( $request->get( 'descriptionLink' ) ) ? $sw = 0 : $request->get( 'descriptionLink' );
        $link = is_null( $request->get( 'link' ) ) ? $sw = 0 : $request->get( 'link' );
        $q = $em->getRepository( 'PaginaSpccBundle:Link' )->findOneBy( array( 'link'=>$link ) );
        if ( $q ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>"El enlace: {$link} ya se encuentra registrado"
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }

        if ( $sw === 0 ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>'Debe llenar los campos marcados como obligatorios'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
        try {
            $em->getConnection()->beginTransaction();
            $q = new Link();
            $q->setLinkTitle( $linkTitle );
            $q->setDescriptionLink( $descriptionLink );
            $q->setLink( $link );
            $q->setState( ( boolean )  1 );
            $q->setRegisterDate( $fechaActual );
            $q->setUserId( $userId );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=>'Se creo correctamente el enlace'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $respuesta = array(
                'ok'=> false,
                'message'=>'Se genero el error nro. ' . $e->getStatus() . ' - ' . $e.getMessage()
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
    }

    public function listLinkAction( Request $request ) {
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Link' )->findAll();
        if ( !$q ) {
            $resultado = array(
                'ok'=> false,
                'message'=>'No Existen enlaces'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        $resultado = array(
            'ok'=> true,
            'message'=>$q
        );
        $response = new JsonResponse();
        return $response->setData( $resultado );
    }

    public function updateLinkAction( Request $request ) {
        $sw = 1;
        $userId = ( int )1;
        date_default_timezone_set( 'America/La_Paz' );
        $fechaActual = new \DateTime( date( 'Y-m-d H:i:s' ) );
        $linkId = is_null( $request->get( 'linkId' ) )?$sw = 0:$request->get( 'linkId' );
        $linkTitle = is_null( $request->get( 'linkTitle' ) ) ? $sw = 0 : $request->get( 'linkTitle' );
        $descriptionLink = is_null( $request->get( 'descriptionLink' ) ) ? $sw = 0 : $request->get( 'descriptionLink' );
        $link = is_null( $request->get( 'link' ) ) ? $sw = 0 : $request->get( 'link' );

        $em = $this->getDoctrine()->getManager();
        if ( $sw === 0 ) {
            $respuesta = array(
                'ok'=> false,
                'message'=>'Debe llenar los campos marcados como obligatorios'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
        try {
            $em->getConnection()->beginTransaction();
            $q = $em->getRepository( 'PaginaSpccBundle:Link' )->find( $linkId );
            $q->setLinkTitle( $linkTitle );
            $q->setDescriptionLink( $descriptionLink );
            $q->setLink( $link );
            $q->setRegisterDate( $fechaActual );
            $q->setUserId( $userId );
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=>'Se modifico correctamente el enlace'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $respuesta = array(
                'ok'=> false,
                'message'=>'Se genero el error nro. ' . $e->getStatus() . ' - ' . $e.getMessage()
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
    }

    public function delLinkAction( Request $request ) {
        $releaseId = $request->get( 'linkId' );
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Link' )->find( $releaseId );
        if ( !$q ) {
            $resultado = array(
                'ok'=> false,
                'message'=>'No Existen el enlace'
            );
            $response = new JsonResponse();
            return $response->setData( $resultado );
        }
        try {
            $em->getConnection()->beginTransaction();
            if ( $q->getState() === true ) {
                $q->setState( false );
            } else {
                $q->setState( true );
            }
            $em->persist( $q );
            $em->flush();
            $em->getConnection()->commit();
            $respuesta = array(
                'ok'=> true,
                'message'=>'Se actualizo correctamente el enlace'
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        } catch( Exception $e ) {
            $em->getConnection()->rollback();
            $respuesta = array(
                'ok'=> false,
                'message'=>'Se genero el error nro. ' . $e->getStatus() . ' - ' . $e.getMessage()
            );
            $response = new JsonResponse();
            return $response->setData( $respuesta );
        }
    }
    //***************************
    //FUNCIONES
    //***************************

    function configuracion() {
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository( 'PaginaSpccBundle:Configuration' );
        $r = $q->createQueryBuilder( 'c' )
        ->select( 'c.sliderQuantity, c.commentsQuantity, c.newsQuality' )
        ->setMaxResults( 1 )
        ->distinct()
        ->getQuery();
        $configuration = $r->getResult();
        return  $configuration;
    }

    function upload( $request, $file, $size, $entity, $campo, $folder, $array ) {

        if ( $request->getMethod() === 'POST' ) {
            $em = $this->getDoctrine()->getManager();
            $FILE = $_FILES[$file];
            $name = $FILE['name'];
            $type = $FILE['type'];
            $tmp = $FILE['tmp_name'];
            $error = $FILE['error'];
            $size = $FILE['size']/ $size;
            $recDato = $em->getRepository( 'PaginaSpccBundle:'.$entity )->findOneBy( array( $campo =>$name ) );
            if ( !$recDato ) {
                $file = $request->files->get( $file );
                $valid_file_type = $array;
                if ( ( $file instanceof UploadedFile ) && ( $error === 0 ) ) {
                    if ( in_array( strtolower( $type ), $valid_file_type ) || $size < 5 ) {
                        $fileTmpPath = $name;
                        $dest_path = '../web/backend/'.$folder.'/' . $name;
                        if ( move_uploaded_file( $file->getPathname(), $dest_path ) == true ) {
                            try {
                                $respuesta = array(
                                    'ok'=> true,
                                    'message'=>$name
                                );
                                return $respuesta;
                            } catch( Exception $e ) {
                                $respuesta = array(
                                    'ok'=> false,
                                    'message'=> 'Algo Salio Mal,\nVuelva a intentar!!'
                                );
                                return respuesta;
                            }
                        }
                    }
                } else {

                    $respuesta = array(
                        'ok'=> false,
                        'message'=> 'Algo Salio Mal,\nVuelva a intentar!!'
                    );
                    return $respuesta;
                }
            } else {
                $respuesta = array(
                    'ok'=> false,
                    'message'=> 'Se subio un archivo anteriormente con este mismo nombre.'
                );
                return $respuesta;
            }
        }
    }
}