<template>
    <div :id="id" class="board" @dragover.prevent @drop.prevent="drop">
        <slot />
    </div>
</template>

<script>
export default {
    props: ["id"],
    methods: {
        drop: e => {
            //  get current user's id from meta tag
            const user_id = document
                .querySelector("meta[name='user-id']")
                .getAttribute("content");

            //  get the target task based on task_id
            const task_id = e.dataTransfer.getData("task_id");
            //  get the element based on task_id
            const task = document.getElementById(task_id);
            //  show the target task when dropped on the board
            task.style.display = "block";
            //  append the target task on the board where it is dropped
            e.target.appendChild(task);

            var task_data = "";
            var board_data = "";

            //  get task based on task id and current user id
            fetch(
                "api/task/" +
                    e.target.children[e.target.children.length - 1].id +
                    "/" +
                    user_id
            )
                .then(res => res.json())
                .then(res => {
                    task_data = res.data;

                    //  get board based on board id and current user id
                    fetch("api/board/" + e.target.id + "/" + user_id)
                        .then(res => res.json())
                        .then(res => {
                            board_data = res.data;

                            //  get task based on id for updating new board's name
                            fetch("api/task/" + user_id, {
                                method: "put",
                                body: JSON.stringify({
                                    task_id:
                                        e.target.children[
                                            e.target.children.length - 1
                                        ].id,
                                    user_id: board_data.user_id,
                                    board_name: board_data.name,
                                    name: task_data.name,
                                    description: task_data.description
                                }),
                                headers: {
                                    "Content-Type": "application/json"
                                }
                            })
                                .then(res => res.json())
                                .catch(err => console.log(err));
                        });
                });
        }
    }
};
</script>
