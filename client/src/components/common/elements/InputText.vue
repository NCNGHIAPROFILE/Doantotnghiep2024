<template>
    <ValidationProvider
        v-slot="{ errors }"
        :name="validation_label"
        :rules="validation_rules"
        :vid="vid"
        ref="provider"
    >
        <v-text-field
            v-model="val"
            dense
            color="primary"
            :disabled="!editable"
            :error-messages="errors"
            :suffix="suffix"
            :prefix="prefix"
            :type="type"
            :placeholder="editable ? placeholder : ''"
            @input="$emit('onInput', { name, value: val })"
            @click="$emit('onClick')"
            @click:append="$emit('onClickAppend')"
            @blur="$emit('onBlur')"
            @focusout="$emit('focusout', { name, value: val})"
            :label="label"
            outlined
        >
            <template slot="prepend">
                <v-icon color="black lighten-1" dark right>
                  {{ icon_prepend }}
                </v-icon>
            </template>
            <template slot="append">
                <v-icon color="black lighten-1" dark right>
                  {{ icon_append }}
                </v-icon>
            </template>
        </v-text-field>
    </ValidationProvider>
</template>
<script>
import {ValidationProvider} from "vee-validate";

export default {
    components: {
        ValidationProvider,
    },
    props: {
        editable: {
            type: Boolean,
            default: false,
        },
        name: {
            type: String,
        },
        values: {
            type: Object,
        },
        validation_rules: {
            type: String,
        },
        validation_label: {
            type: String,
        },
        placeholder: {
            type: String,
            default: "",
        },
        label: {
            type: String,
        },
        suffix: {
            type: String,
            default: "",
        },
        vid: {
            type: String,
        },
        prefix: {
            type: String,
            default: "",
        },
        type: {
            type: String,
        },
        icon_prepend: {
            type: String,
        },
        icon_append: {
            type: String,
        },
    },
    data: () => {
        return {
            val: "",
        };
    },
    computed: {
        isValid() {
            return this.$refs['provider'].errors.length === 0;
        }
    },  
    mounted() {
        this.$watch(
            () => [this.values, this.name],
            (newValue) => {
                const formValues = newValue[0];
                const name = newValue[1];
                if (formValues && name) this.val = formValues[name];
            },
            {immediate: true, deep: true}
        );
    },
};
</script>
