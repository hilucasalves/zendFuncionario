<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $request = $this->getRequest();
        $result = array();
        if ($request->isPost()) {
            try {
                $nome = $request->getPost("nome");
                $cpf = $request->getPost("cpf");
                $salario = $request->getPost("salario");

                $funcionario = new \Application\Model\Funcionario();
                $funcionario->setNome($nome);
                $funcionario->setCpf($cpf);
                $funcionario->setSalario($salario);

                $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
                $em->persist($funcionario);
                $em->flush();

                $result["resp"] = $funcionario->getNome() . ", enviado corretamente!";
            } catch (Exception $e) {
                
            }
        }

        return new ViewModel($result);
    }

    public function listarAction() {
        
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $lista = $em->getRepository("Application\Model\Funcionario")->findAll();
        
        /*
        $sql = "SELECT f 
                FROM Application\Model\Funcionario f
                
                ORDER BY f.nome DESC";
        
        $sql = $em->createQuery($sql);

        $lista = $sql->getResult();         
        
        $sql = $em->createQuery("SELECT f
                                 FROM Application\Model\Funcionario f
                                 WHERE f.nome LIKE :nome");
        $sql->setParameters(array(
                'nome' => 'l%',
                ));

        $lista = $sql->getResult();
        */
        
        return new ViewModel(array('lista' => $lista));
    }

    public function excluirAction() {
        $id = $this->params()->fromRoute("id", 0);
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $funcionario = $em->find("Application\Model\Funcionario", $id);
        $em->remove($funcionario);
        $em->flush();

        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'listar'));
    }

    public function editarAction() {
        $id = $this->params()->fromRoute("id", 0);
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");

        $funcionario = $em->find("Application\Model\Funcionario", $id);
        $request = $this->getRequest();
        if ($request->isPost()) {
            try {
                $nome = $request->getPost("nome");
                $cpf = $request->getPost("cpf");
                $salario = $request->getPost("salario");

                $funcionario->setNome($nome);
                $funcionario->setCpf($cpf);
                $funcionario->setSalario($salario);

                $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
                $em->merge($funcionario);
                $em->flush();
            } catch (Exception $e) {
                
            }

            return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'listar'));
        }

        return new ViewModel(array('f' => $funcionario));
    }

}
