import Guest from "@/src/components/guest";
import Title from "@/src/components/navigation/title";
import RegisterForm from "@/src/components/register/registerform";

export default function Page(){
  return(
    <>
      <Title />
      <Guest>
        <RegisterForm />
      </Guest>
    </>
  )
}