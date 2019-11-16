import SettingsModal from '@fof/components/admin/settings/SettingsModal';
import BooleanItem from '@fof/components/admin/settings/items/BooleanItem';
import NumberItem from '@fof/components/admin/settings/items/NumberItem';
import StringItem from '@fof/components/admin/settings/items/StringItem';

app.initializers.add('giffgaff-stopforumspam', () => {
    app.extensionSettings['giffgaff-stopforumspam'] = () =>
        app.modal.show(
            new SettingsModal({
                title: app.translator.trans('giffgaff-stopforumspam.admin.settings.title'),
                size: 'medium',
                items: [
                    <BooleanItem key="giffgaff-stopforumspam.username">
                        {app.translator.trans('giffgaff-stopforumspam.admin.settings.username_label')}
                    </BooleanItem>,
                    <BooleanItem key="giffgaff-stopforumspam.ip">{app.translator.trans('giffgaff-stopforumspam.admin.settings.ip_label')}</BooleanItem>,
                    <BooleanItem key="giffgaff-stopforumspam.email">{app.translator.trans('giffgaff-stopforumspam.admin.settings.email_label')}</BooleanItem>,
                    <div className="Form-group">
                        <label>{app.translator.trans('giffgaff-stopforumspam.admin.settings.frequency_label')}</label>
                        <NumberItem key="giffgaff-stopforumspam.frequency" simple />
                        <br />
                        <p className="helpText">
                            {app.translator.trans('giffgaff-stopforumspam.admin.settings.frequency_text')} <br />
                            {app.translator.trans('giffgaff-stopforumspam.admin.settings.frequency_example_text')}
                        </p>
                    </div>,
                    app.initializers.has('fof-spamblock') ? (
                        <div className="Form-group">
                            <label>{app.translator.trans('giffgaff-stopforumspam.admin.settings.api_key_label')}</label>
                            <StringItem key="giffgaff-stopforumspam.api_key" simple />
                            <br />
                            <p className="helpText">
                                {app.translator.trans('giffgaff-stopforumspam.admin.settings.api_key_text')} <br />
                                {app.translator.trans('giffgaff-stopforumspam.admin.settings.api_key_instructions_text', {
                                    register: <a href="https://www.stopforumspam.com/forum/register.php" />,
                                    key: <a href="https://www.stopforumspam.com/keys" />,
                                })}
                            </p>
                        </div>
                    ) : (
                        []
                    ),
                ],
            })
        );
});
