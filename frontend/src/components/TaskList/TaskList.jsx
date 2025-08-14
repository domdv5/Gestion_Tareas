import React from "react";
import TaskItem from "../TaskItem/TaskItem";
import "./TaskList.css";

const TaskList = ({ tasks, deleteTask, toggleTaskCompletion, updateTask }) => {
  return (
    <div className="task-list">
      {tasks.map((task) => (
        <TaskItem
          key={task.id}
          task={task}
          onDelete={deleteTask}
          onToggle={toggleTaskCompletion}
          onUpdate={updateTask}
        />
      ))}
    </div>
  );
};

export default TaskList;
