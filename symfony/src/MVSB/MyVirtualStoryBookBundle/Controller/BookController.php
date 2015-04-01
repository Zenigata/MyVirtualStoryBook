<?php

namespace MVSB\MyVirtualStoryBookBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BookController extends MVSBController
{
    /**
     * @Post("/books")
     */
    public function createBookAction(Request $request)
    {
        $this->logRoute($request);
        $serializer = $this->get('jms_serializer');
        $bookService = $this->get('mvsb.book.service');
        
        $json = $request->getContent();
        $book = $serializer->deserialize($json, 'MVSB\MyVirtualStoryBookBundle\Entity\Book', 'json');
        
        $bookService->addNewBook($book);
        
        return new Response('',Response::HTTP_NO_CONTENT);
    }
    
    /**
     * @Get("/books/{id}")
     */
    public function getBookByIdAction(Request $request, $id)
    {
        $this->logRoute($request);
        $bookService = $this->get('mvsb.book.service');
        $book = $bookService->getBookById($id);

        return $this->serializeAndBuildSONResponse($book,Response::HTTP_OK);
    }
    
    /**
     * @Patch("/books/{id}")
     */
    public function putBookByIdAction(Request $request, $id)
    {
        $this->logRoute($request);
        $serializer = $this->get('jms_serializer');
        $bookService = $this->get('mvsb.book.service');
        
        $json = $request->getContent();
        $properties = json_decode($json);
        $book = $bookService->updateBook($id,$properties);
        
        return new Response('',Response::HTTP_OK);
    }
    
    /**
     * @Delete("/books/{id}")
     */
    public function deleteBookByIdAction(Request $request, $id)
    {
        $this->logRoute($request);
        $bookService = $this->get('mvsb.book.service');
        $bookService->deleteBookById($id);

        return new Response('',Response::HTTP_NO_CONTENT);
    }
    
    /**
     * @Get("/books")
     */
    public function getPublishedBooksAction(Request $request)
    {
        $this->logRoute($request);
        $bookService = $this->get('mvsb.book.service');
        $books = $bookService->getPublishedBooks();

        return $this->serializeAndBuildSONResponse($books,Response::HTTP_OK);
    }
    
    /**
     * @Post("/books/{id}/pages")
     */
    public function addBookPageAction(Request $request, $id)
    {
        $this->logRoute($request);
         $bookService = $this->get('mvsb.book.service');
        $page = $bookService->createNewPage($id);

        return $this->serializeAndBuildSONResponse($page,Response::HTTP_CREATED);
        
    }
    
    /**
     * @Get("/books/{id}/pages")
     */
    public function getBookPagesAction(Request $request, $id)
    {
        $this->logRoute($request);
        $bookService = $this->get('mvsb.book.service');
        $book = $bookService->getBookById($id);
        $pages = $book->getPages();
        return $this->serializeAndBuildSONResponse($pages,Response::HTTP_OK);
    }
    
    /**
     * @Get("/genres")
     */
    public function getAllBookGenresAction(Request $request)
    {
        $this->logRoute($request);
        $bookService = $this->get('mvsb.book.service');
        $genres = $bookService->getAllBookGenres();

        return $this->serializeAndBuildSONResponse($genres,Response::HTTP_OK);
    }
    
    /**
     * @Post("/books/{id}/publish")
     */
    public function publishBookPageAction(Request $request, $id)
    {
        $this->logRoute($request);
        $bookService = $this->get('mvsb.book.service');
        $bookService->publishBook($id);
        
        return new Response('',Response::HTTP_NO_CONTENT);
    }
    
}
