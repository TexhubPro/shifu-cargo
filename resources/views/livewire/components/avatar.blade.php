<flux:dropdown position="bottom" align="end">
    <flux:profile :chevron="false" avatar="https://unavatar.io/x/calebporzio" size="lg" />

    <flux:navmenu>
        <flux:navmenu.item href="#" icon="cog-8-tooth">Настройки аккаунта</flux:navmenu.item>

        <flux:navmenu.item wire:click="load" icon="arrow-right-start-on-rectangle" variant="danger">Выйти из аккаунта
        </flux:navmenu.item>
    </flux:navmenu>
</flux:dropdown>