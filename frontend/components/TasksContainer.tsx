import { getTasks } from "@/lib/actions"
import Task from "./Task"

type taskType = {
  task_id: number
  task_content: string
  isDone: number
}

export default async function TasksContainer() {
  const tasks: taskType[] = await getTasks()
  const doneTasks: taskType[] = tasks.filter((task) => task.isDone == 1)
  const undoneTasks: taskType[] = tasks.filter((task) => task.isDone == 0)

  return (
    <div className="w-full h-full flex flex-col gap-4">
      {
        undoneTasks.map((task, index) => (
          <Task key={index} task={task}/>
        ))
      }
      <div className="divider">Ukończone</div>
      {
        doneTasks.map((task, index) => (
          <Task key={index} task={task}/>
        ))
      }
    </div>
  )
}
