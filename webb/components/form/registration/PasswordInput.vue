<template>
    <input
        id="password"
        v-model="password"
        class="center"
        name="password"
        placeholder="password"
        type="password"
        @input="emit"
    />
    <input
        id="password_repeat"
        v-model="password_repeat"
        class="center"
        name="password_repeat"
        placeholder="repeat password"
        type="password"
        @input="emit"
    />
    <div class="password-requirements">
        <ul>
            <li v-for="{ message, status } in assertions">
                <span :class="{ green: status }">{{ message }}</span>
            </li>
        </ul>
    </div>
</template>

<script lang="ts" setup>
    import { UsePasswordInput, PasswordRequirements } from "@/composables/UsePasswordInput";

    const emits = defineEmits<{
        (event: 'input', value: PasswordRequirements): void,
    }>();

    const { requirements, password, password_repeat, assertions } = UsePasswordInput();
    const emit = () => emits('input', requirements());
</script>

<style lang="scss" scoped>
    input {
        &.center {
            display: block;
            margin: auto;
        }
    }
    div.password-requirements {
        .green {
            color: green;
        }
    }
</style>
