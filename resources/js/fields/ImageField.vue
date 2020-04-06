<template>
    <field-wrapper :name="field.name" :label="field.label || field.name" :errors="validationErrors">
        <div v-if="dataUrl">
            <div class="h-40 flex justify-center rounded border border-2 border-dashed">
                <img :src="dataUrl"
                     alt
                     class="rounded-full w-40 h-40"
                     ref="img"
                >
            </div>
            <div class="flex justify-around py-6">
                <button class="btn" @click="save" type="button">save</button>
                <button class="btn" @click="createCropper" type="button">crop</button>
                <button class="btn" @click="$refs.imageInput.click()" type="button">Change Image</button>
            </div>
        </div>
        <div v-else @click="$refs.imageInput.click()"
             class="h-40 flex justify-center items-center rounded border border-2 border-dashed cursor-pointer">
            <p class="text-center">Click to add image</p>
        </div>

        <input
            class="hidden"
            :class="{'border-red-600': !!hasValidationErrors}"
            :id="field.name"
            :name="field.name"
            @change="imageChanged"
            ref="imageInput"
            type="file"
        />
    </field-wrapper>
</template>
<script>
    import FormField from "../lib/mixins/FormField";
    import 'cropperjs/dist/cropper.css'
    import Cropper from 'cropperjs';

    export default {
        mixins: [FormField],
        data() {
            return {
                cropper: false,
                updated: false,
                reader: new FileReader(),
                dataUrl: false,
                imageBlob: false
            }
        },
        mounted() {
            this.imageInput = this.$refs.imageInput;
        },
        methods: {
            createCropper() {
                if (this.cropper) {
                    this.cropper.destroy()
                }
                this.cropper = new Cropper(this.$refs.img, {
                    aspectRatio: 1,
                    autoCropArea: 1,
                    viewMode: 1,
                    movable: false,
                    zoomable: false
                })
            },
            imageChanged(e) {
                if (e.target.files != null && e.target.files[0] != null) {
                    this.reader.onload = event => {
                        this.dataUrl = event.target.result;
                        if (this.cropper) {
                            this.cropper.destroy()
                        }
                    };
                    this.reader.readAsDataURL(e.target.files[0]);
                    this.imageBlob = e.target.files[0];
                    this.updated = true;
                }
            },
            async save() {
                this.imageBlob = await new Promise(resolve => {
                    this.cropper.getCroppedCanvas(this.outputOptions).toBlob(blob => {
                        return resolve(blob);
                    })
                });
                this.reader.readAsDataURL(this.imageBlob)
            },
            fill(data) {
                if (this.updated && this.imageBlob) {
                    data[this.field.name] = this.imageBlob;
                }
                return data;
            }
        }
    }
</script>
