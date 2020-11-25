<?php

namespace Pagina\SpccBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        // $id_user = $this->session->get('id_user');
        // if (!$id_user) {
        //     return $this->redirect($this->generateUrl('spcc_certificado_homepage'));
        // }
        $em = $this->getDoctrine()->getManager();
        $q = $em->getRepository('SpccCertificadoBundle:Planificacion');
        $r = $q->createQueryBuilder('p')
                ->select("e.id evento, o.ocupacionDesc, reg.depto, reg.prov, reg.mun, p.lugar, p.fechaIni, p.fechaFin, r.cantCarpetas,  reg1.depto deptoEvento , e.fechaIni ,e.fechaFin, p.id")
                ->leftJoin('SpccCertificadoBundle:Evento', 'e', 'WITH', 'e.id = p.evento')
                ->leftJoin('SpccCertificadoBundle:Revision', 'r', 'WITH', 'r.plan = p.id')
                ->leftJoin('SpccCertificadoBundle:Ocupacion', 'o', 'WITH', 'o.id = p.ocupacion')
                ->leftJoin('SpccCertificadoBundle:Regiones', 'reg', 'WITH', 'reg.deptoId = p.deptoId and reg.provId = p.provId and reg.munId = p.munId')
                ->leftJoin('SpccCertificadoBundle:Regiones', 'reg1', 'WITH', 'reg1.deptoId = e.depto')
                ->leftJoin('SpccCertificadoBundle:Usuario', 'u', 'WITH', 'u.id = r.usuarioRegImp')
                ->leftJoin('SpccCertificadoBundle:Persona', 'per', 'WITH', 'per.id = u.persona')
                ->where('r.estadoId = 5')
                ->andWhere('r.usuarioAsig = :idUser')
                ->setParameter(':idUser', $id_user)
                ->orderBy('e.id', 'DESC')
                ->groupBy('e.id, o.ocupacionDesc, reg.depto, reg.prov, reg.mun, p.lugar, p.fechaIni, p.fechaFin, r.cantCarpetas,  reg1.depto , e.fechaIni ,e.fechaFin, p.id')
//                ->setMaxResults(30)
                ->distinct()
                ->getQuery();
        $result['res'] = $r->getResult();

        foreach ($result['res'] as $key => $v) {
            $result['res'][$key]['fechaIni'] = $result['res'][$key]['fechaIni']->format('d-m-Y');
            $result['res'][$key]['fechaFin'] = $result['res'][$key]['fechaFin']->format('d-m-Y');
        }

        $q1 = $em->getRepository('SpccCertificadoBundle:Inscripcion');
        $q2 = $q1->createQueryBuilder('i')
                ->select('COUNT(i.id) suma, p.id')
                ->leftJoin('SpccCertificadoBundle:Planificacion', 'p', 'WITH', 'p.id = i.plan')
                ->groupBy('p.id')
                ->getQuery();
        $result['count'] = $q2->getResult();
        $roles = $em->getRepository('SpccCertificadoBundle:Rol')->findOneBy(array('id' => $this->session->get('rol_sel')));
        return $this->render('SpccCertificadoBundle:Transcripcion:indexTrans.html.twig', array(
                    'rol_id' => $roles->getId(),
                    'tablaIndex' => $result['res'],
                    'suma' => $result['count'],
                    'rol' => $roles->getRoles()));
    }
}
