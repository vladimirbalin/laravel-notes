<template>
    <div class="tc-note">
        <div class="tc-note-header">
                <span @click="deleteNote" class="tc-note-close">
                    <i class="fas fa-times">X</i>
                </span>
        </div>
        <div class="tc-note-title" contenteditable="" @blur="titleChanged">
            {{ note.title }}
        </div>
        <div class="tc-note-title" contenteditable="">
            {{ note.id }}
        </div>
        <div v-if="note.errors" class="errors"
             v-for="(error, field) in note.errors" :key="field">
            <span>Not saved: </span><p>{{ error }}</p>
        </div>
        <div class="tc-note-body" contenteditable="" @blur="contentChanged">
            {{ note.content }}
        </div>
    </div>
</template>

<script>
export default {
    name: "Note",
    props: {
        note: {
            type: Object,
            required: true
        }
    },
    methods: {
        deleteNote() {
            this.$emit('removeNote', this.note)
        },
        titleChanged(event) {
            this.note.title = event.target.innerText
            this.$emit('updateNote', this.note)
        },
        contentChanged(event) {
            this.note.content = event.target.innerText
            this.$emit('updateNote', this.note)
        }
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
.errors {
    margin-bottom: 5px;
    padding: 5px 5px;
    color: #fff;
    background-color: #ff6969;
    font-size: 12px;
}

.tc-note {
    background-color: #f0c806;
    border-radius: 8px;
    width: 280px;
    margin: 0 10px 20px;
    box-shadow: 1px 3px 5px rgba(0, 0, 0, 0.2);
    transition: all 0.5s;
    cursor: pointer;
    font-family: 'Caveat', cursive;

    .tc-note-header {
        padding: 10px 16px 0;

        .tc-note-close {
            display: inline-block;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            line-height: 24px;
            text-align: center;
            transition: all 0.3s;

            &:hover {
                background-color: rgba(0, 0, 0, 0.2);
            }

            &:focus {
                box-shadow: inset 2px 3px 0px rgba(0, 0, 0, 0.8);
            }
        }

        .tc-note-close {
            float: right;
        }
    }

    .tc-note-title,
    .tc-note-body {
        outline: 0;
    }

    .tc-note-title {
        font-size: 18px;
        padding: 10px 16px;
        font-weight: bold;
    }

    .tc-note-body {
        font-size: 16px;
        padding: 10px 16px 16px;
        height: 100%;
    }

    &:hover {
        box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.3);
    }
}
</style>
