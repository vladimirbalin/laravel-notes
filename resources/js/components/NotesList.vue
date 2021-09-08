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

export default {
    name: "NotesList",
    components: {Note},
    data() {
        return {
            notes: []
        }
    },
    mounted() {
        axios.get('/api/notes')
            .then(res => {
                this.notes = [...res.data]
            })
            .catch(err => {
                console.log(err)
            })
    },
    methods: {
        async updateNote(note) {
            const url = '/api/notes/' + note.id;

            await axios.put(url, note)
                .then(res => {
                    const indexOf = this.notes.findIndex(el => el.id === note.id);
                    let newNote = this.notes[indexOf];

                    if (res.status === 201) {
                        newNote.errors = res.data.errors;
                    } else {
                        newNote = res.data;
                        newNote.errors = [];
                    }
                    const begin = this.notes.slice(0, indexOf);
                    const end = this.notes.slice(indexOf + 1);

                    this.notes = [...begin, newNote, ...end];
                })
                .catch(err => {
                    console.log(err)
                })
        },
        async addNote() {
            const newNote = {title: 'Please enter the title...', content: 'Please enter the content', errors: []};
            const url = '/api/notes';
            await axios.post(url, newNote)
                .then(res => {
                    console.log(res)
                    this.notes = [newNote, ...this.notes];
                })
                .catch(err => {
                })


        },
        async removeNote(note) {
            const url = '/api/notes/' + note.id;

            await axios.delete(url)
                .then(res => {
                    const indexOf = this.notes.findIndex(el => el.id === note.id);
                    const begin = this.notes.slice(0, indexOf);
                    const end = this.notes.slice(indexOf + 1);
                    this.notes = [...begin, ...end];
                }).catch(err => {
                })
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
