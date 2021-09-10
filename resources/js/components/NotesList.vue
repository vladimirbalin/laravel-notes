<template>
    <div class="tc-notes-wrapper">
        <button @click="addNote">Add note</button>
        <div class="tc-notes">
            <note v-for="(note, index) in notes"
                  :key="index"
                  :note="note"
                  @updateNote="updateNote"
                  @removeNote="removeNote"/>
        </div>
    </div>

</template>

<script>
import Note from "./Note";
import httpService from "../services/http.service";

export default {
    name: "NotesList",
    components: {Note},
    data() {
        return {
            notes: []
        }
    },
    async mounted() {
        const {data} = await httpService('notes');
        this.notes = data.sort((a, b) => {
            if (a.created_at > b.created_at) {
                return -1;
            } else {
                return 1;
            }
        });
    },
    methods: {
        async updateNote(note) {
            const indexOf = this.notes.findIndex(el => el.id === note.id);
            let updatedNote = this.notes[indexOf];

            try {
                const url = 'notes/' + note.id;
                const {data} = await httpService.put(url, note);
                updatedNote = data;
                updatedNote.errors = [];
            } catch (e) {
                updatedNote.errors = e.response.data.errors
            }

            const begin = this.notes.slice(0, indexOf);
            const end = this.notes.slice(indexOf + 1);
            this.notes = [...begin, updatedNote, ...end];
        },
        async addNote() {
            const newNote = {title: 'Title', content: 'Content', errors: []};
            const url = 'notes';
            const {data, status} = await httpService.post(url, newNote);

            this.notes = [data, ...this.notes];
        },
        async removeNote(note) {
            const url = 'notes/' + note.id;
            const {status} = await httpService.delete(url);

            if (status === 202) {
                const indexOf = this.notes.findIndex(el => el.id === note.id);
                const begin = this.notes.slice(0, indexOf);
                const end = this.notes.slice(indexOf + 1);
                this.notes = [...begin, ...end];
            }
            if (status === 404) {
                alert('noth happened');
            }
        }
    }
}
</script>

<style scoped>
.tc-notes-wrapper {
    padding: 30px;
}

.tc-notes {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin: 0 auto;
}

</style>
