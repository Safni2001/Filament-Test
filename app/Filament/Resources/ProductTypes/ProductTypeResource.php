<?php

namespace App\Filament\Resources\ProductTypes;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\ProductType;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Http;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Filament\Resources\ProductTypes\Pages\ManageProductTypes;

class ProductTypeResource extends Resource
{
    protected static ?string $model = ProductType::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Product Types';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'Product Type';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('api_unique_number')
                    ->numeric()
                    ->suffixAction(
                        Action::make('fetch_api_unique_number')
                            ->icon('heroicon-m-arrow-path')
                            ->color('info')
                            ->action(function (Set $set, Get $get): void {
                                $streetName = $get('street_name');
                                $suburb = $get('suburb');
                                $postcode = $get('postcode');
                                $state = $get('state');

                                if (!$streetName || !$suburb || !$postcode || !$state) {
                                    Notification::make()
                                        ->title('Missing Address Fields')
                                        ->body('Please fill in street name, suburb, postcode, and state before fetching API number.')
                                        ->warning()
                                        ->send();
                                    return;
                                }

                                try {
                                    // First, login to get the token
                                    $loginResponse = Http::post('https://extranet.asmorphic.com/api/login', [
                                        'email' => 'project-test@projecttest.com.au',
                                        'password' => 'oxhyV9NzkZ^02MEB',
                                    ]);

                                    if (!$loginResponse->successful()) {
                                        throw new \Exception('Login failed');
                                    }

                                    $token = $loginResponse->json('token');

                                    // Make the API call to find address
                                    $response = Http::withToken($token)->post('https://extranet.asmorphic.com/api/orders/findaddress', [
                                        'company_id' => 17,
                                        'street_name' => $streetName,
                                        'suburb' => $suburb,
                                        'postcode' => $postcode,
                                        'state' => $state,
                                    ]);

                                    if ($response->successful()) {
                                        $apiData = $response->json();
                                        $apiUniqueNumber = $apiData['unique_number'] ?? null;

                                        if ($apiUniqueNumber) {
                                            $set('api_unique_number', $apiUniqueNumber);
                                            Notification::make()
                                                ->title('Success')
                                                ->body('API unique number fetched successfully!')
                                                ->success()
                                                ->send();
                                        } else {
                                            Notification::make()
                                                ->title('No Data Found')
                                                ->body('No unique number found for the provided address.')
                                                ->warning()
                                                ->send();
                                        }
                                    } else {
                                        throw new \Exception('API call failed');
                                    }
                                } catch (\Exception $e) {
                                    Notification::make()
                                        ->title('API Error')
                                        ->body('Failed to fetch API unique number: ' . $e->getMessage())
                                        ->danger()
                                        ->send();
                                }
                            })
                    ),
                TextInput::make('street_name')
                    ->label('Street Name')
                    ->required()
                    ->helperText('Required for API integration'),
                TextInput::make('suburb')
                    ->label('Suburb')
                    ->required()
                    ->helperText('Required for API integration'),
                TextInput::make('postcode')
                    ->label('Postcode')
                    ->required()
                    ->helperText('Required for API integration'),
                TextInput::make('state')
                    ->label('State')
                    ->required()
                    ->helperText('Required for API integration'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Product Type')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('api_unique_number')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProductTypes::route('/'),
        ];
    }
}
