<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewLink extends ViewRecord
{
    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Информация о ссылке')
                    ->schema([
                        TextEntry::make('short_url')
                            ->label('Короткая ссылка')
                            ->copyable(),
                        TextEntry::make('original_url')
                            ->label('Оригинальный URL')
                            ->url(fn ($record) => $record->original_url, shouldOpenInNewTab: true),
                        TextEntry::make('clicks_count')
                            ->label('Всего кликов')
                            ->state(fn ($record) => $record->clicks()->count()),
                        TextEntry::make('created_at')
                            ->label('Дата создания')
                            ->dateTime('d.m.Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}
