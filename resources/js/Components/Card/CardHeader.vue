<template>
    <div class="flex md:flex-row flex-col">
        <h3 class="text-lg font-semibold"><slot/></h3>
        <div class="flex-grow"></div>
        <slot name="right" />
    </div>
</template>
