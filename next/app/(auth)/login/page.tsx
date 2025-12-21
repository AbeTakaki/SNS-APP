import Guest from "@/src/components/guest";
import LoginForm from "@/src/components/login/loginform";
import Title from "@/src/components/navigation/title";

export default function Page() {
  return(
    <>
      <Title />
      <Guest>
        <LoginForm />
      </Guest>
    </>
  )
}