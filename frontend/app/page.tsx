import Login from "@/components/Login";
import Register from "@/components/Register";
import { checkLogin } from "@/lib/actions";
import { redirect } from "next/navigation";

export default async function Home() {
  const data = await checkLogin();
  if(data.ok) {
    redirect("/tasks")
  }

  return (
    <div className="w-full h-full flex flex-col items-center justify-center gap-8">
      <h1 className="text-4xl font-bold">Witaj na DailyTasks</h1>
      <div className="flex flex-row gap-8 items-center">
        <Register />
        <Login />
      </div>
    </div>
  );
}
