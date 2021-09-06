<template>
    <div class="tc-notes-wrapper">
        <div class="tc-notes">
            <note v-for="(note, index) in notes"
                  :key="index"
                  :note="note"/>
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
