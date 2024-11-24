<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make(
                    /**TRANSLATION*/
                    "Driver Information"
                )
                    ->description(
                        /**TRANSLATION*/
                        "Manage driver details with ease."
                    )
                    ->aside()
                    ->schema([
                        Group::make()
                            ->relationship('user')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                                    ->collection(User::MEDIA_COLLECTION_AVATAR)
                                    ->label(
                                        /**TRANSLATION*/
                                        'Avatar'
                                    )
                                    ->avatar()
                                    ->alignCenter(),

                                Forms\Components\TextInput::make('name')
                                    ->label(
                                        /**TRANSLATION*/
                                        'Name'
                                    )
                                    ->placeholder(
                                        /**TRANSLATION*/
                                        'John Doe'
                                    )
                                    ->required(),

                                Forms\Components\TextInput::make('email')
                                    ->label(
                                        /**TRANSLATION*/
                                        'Email'
                                    )
                                    ->placeholder(
                                        /**TRANSLATION*/
                                        'email@example.com'
                                    )
                                    ->email()
                                    ->unique(column: 'email', ignoreRecord: true)
                                    ->required(),
                            ])
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('user.avatar')
                    ->collection(User::MEDIA_COLLECTION_AVATAR)
                    ->circular()
                    ->label(
                        /**TRANSLATION*/
                        'Avatar'
                    ),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(
                        /**TRANSLATION*/
                        'Name'
                    )
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label(
                        /**TRANSLATION*/
                        'Email'
                    )
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('trip_count')
                    ->label(
                        /**TRANSLATION*/
                        'Trips'
                    )
                    ->badge()
                    ->getStateUsing(fn(Driver $driver) => $driver->trips()->count())
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(
                        /**TRANSLATION*/
                        'Created at'
                    )
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(
                        /**TRANSLATION*/
                        'Updated at'
                    )
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
