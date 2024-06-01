import AddTaskForm from "@/components/AddTaskForm"
import TasksContainer from "@/components/TasksContainer"

export default async function Homepage() {
  return (
    <div className="w-full h-full md:w-1/2 flex flex-col gap-4 pt-4">
      <AddTaskForm />
      <TasksContainer />
    </div>
  )
}
