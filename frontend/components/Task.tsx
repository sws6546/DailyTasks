"use client"

import { doneTask } from "@/lib/actions"
import { useRouter } from "next/navigation"

type taskType = {
  task_id: number
  task_content: string
  isDone: number
}

export default function Task({ task }: {task: taskType}) {
  const router = useRouter()
  return (
    <div className="w-full flex flex-col gap-4">
      <div role="alert" className={`alert alert-${task.isDone==0 ? "info" : "success"} rounded-[100px]`}>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" className="stroke-current shrink-0 w-6 h-6"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>{task.task_content}</span>
        <button onClick={() => {
          doneTask(task.task_id)
          router.refresh()
        }} className="btn btn-warning">{task.isDone==0 ? "Ukoncz" : "Przywróć"}</button>
      </div>
    </div>
  )
}
