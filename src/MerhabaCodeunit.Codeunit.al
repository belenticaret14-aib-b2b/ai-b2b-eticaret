codeunit 50000 "Merhaba Codeunit"
{
    procedure GetGreeting(): Text
    begin
        exit('Merhaba! Hello from Dynamics 365 Business Central!');
    end;

    procedure GetGreetingInTurkish(): Text
    begin
        exit('Merhaba! Dynamics 365 Business Central''dan selamlar!');
    end;

    procedure SayMerhaba()
    begin
        Message(GetGreeting());
    end;
}
