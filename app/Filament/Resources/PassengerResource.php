<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PassengerResource\Pages;
use App\Filament\Resources\PassengerResource\RelationManagers;
use App\Models\Passenger;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PassengerResource extends Resource
{
    protected static ?string $model = Passenger::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('user_id')
                //     ->relationship('user', 'name')
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('user.avatar')
                    ->collection(User::MEDIA_COLLECTION_AVATAR)
                    ->rounded()
                    ->label(
                    /**TRANSLATION*/
                    'Avatar'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(
                    /**TRANSLATION*/
                    'Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label(
                    /**TRANSLATION*/
                    'Email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('trip_count')
                    ->label(
                    /**TRANSLATION*/
                    'Trips')
                    ->badge()
                    ->getStateUsing(fn(Passenger $passenger) => $passenger->trips()->count())
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(
                    /**TRANSLATION*/
                    'Created at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(
                    /**TRANSLATION*/
                    'Updated at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListPassengers::route('/'),
            // 'create' => Pages\CreatePassenger::route('/create'),
            // 'edit' => Pages\EditPassenger::route('/{record}/edit'),
        ];
    }
}
