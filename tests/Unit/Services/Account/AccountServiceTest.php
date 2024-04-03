<?php


namespace Services\Account;

use App\Models\Account;
use App\Models\Currency;
use App\Repositories\AccountRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\ExpenseRepository;
use App\Repositories\RevenueRepository;
use App\Services\Account\AccountService;
use App\Services\Expense\Exceptions\NotEnoughMoneyException;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\CreatesApplication;
use Tests\TestCase;

class AccountServiceTest extends TestCase
{
    use CreatesApplication;

    private AccountService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createApplication();
        $this->asUser(env('TEST_USER_LOGIN'));
        $this->service = resolve(
            AccountService::class,
            [
                'accountRepository' => $this->mockAccountRepository(),
                'currencyRepository' => $this->mockCurrencyRepository(),
                'revenueRepository' => $this->mockRevenueRepository(),
                'expenseRepository' => $this->mockExpenseRepository(),
            ]
        );
    }

    /**
     * @dataProvider getAccountsData
     */
    public function testGetAccounts(Collection $expected)
    {
        $result = $this->service->getAccounts();

        $this->assertEquals($expected, $result);
    }

    public function getAccountsData(): array
    {
        return [
            [
                (new Collection(
                    [
                        0 => (new Account())->forceFill(
                            [
                                'id' => 21,
                                'user_id' => 14,
                                'name' => 'Наличные',
                                'balance' => 0,
                                'currency_id' => 6,
                                'description' => null,
                                'created_at' => null,
                                'updated_at' => '2024-03-22 19:00:15'
                            ]
                        )
                    ]
                ))
            ]
        ];
    }

    /**
     * @dataProvider getAccountByIdData
     */
    public function testGetAccountById(int $id, array $expected)
    {
        $result = $this->service->getAccountById($id);

        $this->assertEquals($expected, $result);
    }

    public function getAccountByIdData(): array
    {
        return [
            [
                21,
                [
                    'account' => [
                        'id' => 21,
                        'user_id' => 14,
                        'name' => 'Наличные',
                        'balance' => 0,
                        'currency_id' => 6,
                        'description' => null,
                        'created_at' => null,
                        'updated_at' => '2024-03-22 19:00:15'
                    ],
                    'currencies' => [
                        0 => [
                            'id' => 6,
                            'user_id' => 14,
                            'name' => 'Рубль',
                            'symbol' => 'Р',
                            'created_at' => null,
                            'updated_at' => null
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider updateAccountData
     */
    public function testUpdateAccount(
        int $id,
        ?string $name,
        ?int $balance,
        ?int $currency,
        ?string $description,
        int $expected
    ) {
        $result = $this->service->updateAccount(
            $id,
            $name,
            $balance,
            $currency,
            $description
        );

        $this->assertEquals($expected, $result);
    }

    public function updateAccountData(): array
    {
        return [
            [
                21,
                'Наличные',
                100,
                6,
                'test',
                1
            ],
            [
                20,
                'Наличные',
                100,
                6,
                'test',
                0
            ]
        ];
    }

    /**
     * @dataProvider createAccountData
     */
    public function testCreateAccount(
        string $name,
        int $balance,
        int $currency,
        ?string $description,
        bool $expected
    ) {
        $result = $this->service->createAccount(
            $name,
            $balance,
            $currency,
            $description
        );

        $this->assertEquals($expected, $result);
    }

    public function createAccountData(): array
    {
        return [
            [
                'Наличные',
                0,
                6,
                null,
                true
            ]
        ];
    }

    /**
     * @dataProvider deleteAccountData
     */
    public function testDeleteAccount(int $id, mixed $expected)
    {
        $result = $this->service->deleteAccount($id);

        $this->assertEquals($expected, $result);
    }

    public function deleteAccountData(): array
    {
        return [
            [
                21,
                1
            ],
            [
                20,
                0
            ]
        ];
    }

    /**
     * @dataProvider updateBalanceData
     */
    public function testUpdateBalance(int $id, int $balance, bool $expected)
    {
        $result = $this->service->updateBalance($id, $balance);

        $this->assertEquals($expected, $result);
    }

    public function updateBalanceData(): array
    {
        return [
            [
                21,
                200,
                true
            ]
        ];
    }

    /**
     * @dataProvider balanceIncrementData
     */
    public function testBalanceIncrement(int $id, int $sum, bool $expected)
    {
        $result = $this->service->balanceIncrement($id, $sum);

        $this->assertEquals($expected, $result);
    }

    public function balanceIncrementData(): array
    {
        return [
            [
                21,
                20000,
                true
            ]
        ];
    }

    /**
     * @dataProvider balanceDecrementData
     */
    public function testBalanceDecrement(int $id, int $sum, bool $expected, ?string $exception)
    {
        if ($exception) {
            $this->expectException($exception);
        }

        $result = $this->service->balanceDecrement($id, $sum);
        $this->assertEquals($expected, $result);
    }

    public function balanceDecrementData(): array
    {
        return [
            [
                22,
                5000,
                true,
                null
            ],
            [
                22,
                20000,
                false,
                NotEnoughMoneyException::class
            ]
        ];
    }

    private function mockAccountRepository(): AccountRepository
    {
        $mock = Mockery::mock(AccountRepository::class);

        $mock->shouldReceive('getAccounts')
            ->with(14)
            ->andReturn(
                new Collection(
                    [
                        0 => (new Account())->forceFill(
                            [
                                'id' => 21,
                                'user_id' => 14,
                                'name' => 'Наличные',
                                'balance' => 0,
                                'currency_id' => 6,
                                'description' => null,
                                'created_at' => null,
                                'updated_at' => '2024-03-22 19:00:15'
                            ]
                        )
                    ]
                )
            );

        $mock->shouldReceive('getAccountById')
            ->with(14, 21)
            ->andReturn(
                (new Account())->forceFill(
                    [
                        'id' => 21,
                        'user_id' => 14,
                        'name' => 'Наличные',
                        'balance' => 0,
                        'currency_id' => 6,
                        'description' => null,
                        'created_at' => null,
                        'updated_at' => '2024-03-22 19:00:15'
                    ]
                )
            );

        $mock->shouldReceive('getAccountById')
            ->with(14, 22)
            ->andReturn(
                (new Account())->forceFill(
                    [
                        'id' => 21,
                        'user_id' => 14,
                        'name' => 'Наличные',
                        'balance' => 10000,
                        'currency_id' => 6,
                        'description' => null,
                        'created_at' => null,
                        'updated_at' => '2024-03-22 19:00:15'
                    ]
                )
            );

        $mock->shouldReceive('updateAccount')
            ->with(
                14,
                21,
                'Наличные',
                10000,
                6,
                'test'
            )
            ->andReturn(1);

        $mock->shouldReceive('updateAccount')
            ->with(
                14,
                20,
                'Наличные',
                10000,
                6,
                'test'
            )
            ->andReturn(0);

        $mock->shouldReceive('deleteAccount')
            ->with(14, 21)
            ->andReturn(1);

        $mock->shouldReceive('deleteAccount')
            ->with(14, 20)
            ->andReturn(0);

        $mock->shouldReceive('createAccount')
            ->with(
                14,
                'Наличные',
                0,
                6,
                null
            )
            ->andReturn(true);

        $mock->shouldReceive('updateBalance')
            ->with(14, 21, 20000)
            ->andReturn(true);

        $mock->shouldReceive('updateBalance')
            ->with(14, 22, 5000)
            ->andReturn(true);

        return $mock;
    }

    private function mockCurrencyRepository(): CurrencyRepository
    {
        $mock = Mockery::mock(CurrencyRepository::class);

        $mock->shouldReceive('getCurrenciesByUserId')
            ->with(14)
            ->andReturn(
                new Collection(
                    [
                        0 => (new Currency())->forceFill(
                            [
                                'id' => 6,
                                'user_id' => 14,
                                'name' => 'Рубль',
                                'symbol' => 'Р',
                                'created_at' => null,
                                'updated_at' => null
                            ]
                        )
                    ]
                )
            );

        return $mock;
    }

    private function mockRevenueRepository(): RevenueRepository
    {
        $mock = Mockery::mock(RevenueRepository::class);

        $mock->shouldReceive('deleteRevenueByAccountId')
            ->with(14, 21)
            ->andReturn(1);

        $mock->shouldReceive('deleteRevenueByAccountId')
            ->with(14, 20)
            ->andReturn(0);

        return $mock;
    }

    private function mockExpenseRepository(): ExpenseRepository
    {
        $mock = Mockery::mock(ExpenseRepository::class);

        $mock->shouldReceive('deleteExpenseByAccountId')
            ->with(14, 21)
            ->andReturn(1);

        $mock->shouldReceive('deleteExpenseByAccountId')
            ->with(14, 20)
            ->andReturn(0);

        return $mock;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
