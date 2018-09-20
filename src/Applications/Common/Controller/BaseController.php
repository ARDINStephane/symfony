<?php

namespace App\Applications\Common\Controller;

use App\Applications\Common\Repository\BaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseController extends Controller
{
    const FLASH_INFO = 'info';

    protected function findByRepository(BaseRepository $repository, $id)
    {
        $entity = $repository->find($id);
        $this->ifNotFound404($entity);

        return $entity;
    }

    protected function ifNotFound404($entity)
    {
        if (!$entity) {
            throw new NotFoundHttpException();
        }
    }
}
