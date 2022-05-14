<?php
    namespace Tests\Unit\Todo;
    use PHPUnit\Framework\TestCase;
    use Tests\Database\EloquentConnection;
    use Tests\Database\TableCreator;

    use App\Repositories\TodoRepository;
    use App\Services\UnitTestService;
class TodoRepositoryTest extends TestCase
{
    // protected $repository;
    protected $service;
    protected function setUp(): void
    {
        // EloquentConnection::addConnection();

        // $table_creator = new TableCreator();

        // $this->repository = new TodoRepository();
        $this->service = new UnitTestService();
    }

    /**
     * @test
     */
    public function testBasic()
    {
        // arrange 
        $data = [
            'is_test' => true
        ];
        // act
        $result = $this->service->isTest($data);
        // assert
        $this->assertTrue($result);
    }
}
