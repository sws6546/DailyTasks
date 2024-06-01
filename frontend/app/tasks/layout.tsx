import Navbar from "@/components/Navbar";

export default function taskLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <div className="w-full h-full flex flex-col items-center">
      <Navbar />
      {children}
    </div>
  );
}
