<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusResource\Pages;
use App\Filament\Resources\BusResource\RelationManagers;
use App\Models\Bus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BusResource extends Resource
{
    protected static ?string $model = Bus::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function getModelLabel(): string
    {
        return
            /**TRANSLATION*/
            "Bus";
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(
            /**TRANSLATION*/
            "Bus Information")
                ->description(
                    /**TRANSLATION*/
                    "Manage bus details with ease."
                )
                ->aside()
                ->schema([
                    Forms\Components\TextInput::make("license_plate")
                        ->label(
                            /**TRANSLATION*/
                            "License Plate"
                        )
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Forms\Components\TextInput::make("capacity")
                        ->label(
                            /**TRANSLATION*/
                            "Capacity"
                        )
                        ->required()->numeric(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("license_plate")
                    ->label(
                        /**TRANSLATION*/
                        "License Plate"
                    )
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make("capacity")
                    ->label(
                        /**TRANSLATION*/
                        "Capacity"
                    )
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make("trip_count")
                    ->label(
                        /**TRANSLATION*/
                        "Trips"
                    )
                    ->getStateUsing(fn($record) => $record->trips()->count())
                    ->badge()
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make("created_at")
                    ->label(
                        /**TRANSLATION*/
                        "Created at"
                    )
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make("updated_at")
                    ->label(
                        /**TRANSLATION*/
                        "Updated at"
                    )
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
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
            "index" => Pages\ListBuses::route("/"),
            "create" => Pages\CreateBus::route("/create"),
            "edit" => Pages\EditBus::route("/{record}/edit"),
        ];
    }
}
